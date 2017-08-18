<?php declare(strict_types=1);

namespace JSKOS;

use InvalidArgumentException;

const IRI_PATTERN = '!^((?P<scheme>[a-z][a-z0-9+.-]*):)' .
        '((?P<doubleslash>//)(?P<authority>[^/?#]*))?(?P<path>[^?#]*)' .
        '((?<querydef>\?)(?P<query>[^#]*))?(#(?P<fragment>.*))?!';

const DATE_PATTERN = '!^(?P<year>-?\d\d\d\d)' .
        '(-((?P<month>\d\d)(' .
        '-(?P<day>\d\d)' .
        '(T\d\d:\d\d:\d\d(\.\d+)?)?' .
        '(Z|[+-]\d\d:\d\d)?' .
        ')?))?$!';

const LANGUAGE_PATTERN = '/^[a-z]{2,3}(?:-[A-Z]{2,3}(?:-[a-zA-Z]{4})?)?$/';

const LANGUAGE_RANGE_PATTERN = '/^([a-z]{2,3}(?:-[A-Z]{2,3}(?:-[a-zA-Z]{4})?)?)?-$/';

abstract class DataType extends PrettyJsonSerializable
{
    use ObjectConstructor;

    const FIELDS = [];

    /**
     * Get field definition from FIELDS, including parent classes.
     */
    protected static function fieldType(string $field)
    {
        $class = get_called_class();
        while ($class && $class != self::class) {
            if (isset($class::FIELDS[$field])) {
                return $class::FIELDS[$field];
            }
            $class = get_parent_class($class);
        }
    }

    protected function setField(string $field, $value, bool $strict=true)
    {
        if ($field == '@context') {
            return;
        }

        $type = static::fieldType($field);

        if (!$type) {
            if ($strict) {
                throw new InvalidArgumentException(get_class() . "->$field does not exist");
            } else {
                return;
            }
        }

        if (is_null($value)) {
            // set to null
        } elseif (is_array($type)) { # Set or Listing
            if ($type[0] == 'Set') {
                if (is_array($value)) {
                    $class = 'JSKOS\\'.$type[1];
                    $value = new Set(
                        array_map(function ($m) use ($class) {
                            if (is_null($m)) {
                                return null;
                            }
                            if (is_object($m) and is_a($m, $class)) {
                                return $m;
                            }
                            return new $class($m);
                        }, $value)
                    );
                } elseif (!is_a($value, 'JSKOS\Set')) {
                    $msg = get_called_class()."->$field must be a Set";
                    throw new InvalidArgumentException($msg);
                } else {
                    # TODO: check member types
                }
            } else { # Listing
                if (is_array($value)) {
                    $value = new Listing($value);
                } else {
                    # TODO: check member types
                }
            }
        } elseif ($type == 'LanguageMapOfStrings') {
            if (!($value instanceof LanguageMapOfStrings)) {
                $value = new LanguageMapOfStrings($value);
            }
        } elseif ($type == 'LanguageMapOfLists') {
            if (!($value instanceof LanguageMapOfLists)) {
                $value = new LanguageMapOfLists($value);
            }
        } elseif (!DataType::hasType($value, $type)) {
            if ($type == 'ConceptScheme') {
                $value = new ConceptScheme($value);
            } else {
                $msg = get_called_class()."->$field must match JSKOS\DataType::is$type";
                throw new InvalidArgumentException($msg);
            }
        }

        $this->$field = $value;
    }

    public function __set($field, $value)
    {
        $this->setField($field, $value);
    }

    public function &__get($field)
    {
        $type = static::fieldType($field);
        if ($type) {
            if (is_null($this->$field)) {
                $null = null;
                return $null;
            } else {
                return $this->$field;
            }
        } else {
            trigger_error(
                "Undefined property: ".get_called_class()."::$$field",
                \E_USER_NOTICE
            );
            return null;
        }
    }

    public function __isset($field): bool
    {
        return !!static::fieldType($field);
    }

    /**
     * Check whether a given value looks like an URI.
     */
    public static function isURI($uri): bool
    {
        return is_string($uri) and
               preg_match(IRI_PATTERN, $uri) === 1;
    }

    /**
     * Check whether a given value looks like an http/https URL.
     */
    public static function isURL($url): bool
    {
        return is_string($url) and
               preg_match(IRI_PATTERN, $url, $match) and
               ($match[2] == 'http' or $match[2] == 'https');
    }

    /**
     * Check whether a given value looks like a date.
     */
    public static function isDate($date): bool
    {
        return is_string($date) and
               preg_match(DATE_PATTERN, $date) === 1;
    }

    /**
     * Check whether a given value looks like a language tag.
     */
    public static function isLanguage($language): bool
    {
        return is_string($language) and
               preg_match(LANGUAGE_PATTERN, $language) === 1;
    }

    /**
     * Check whether a given value looks like a language range.
     */
    public static function isLanguageRange($range): bool
    {
        return is_string($range) and
               preg_match(LANGUAGE_RANGE_PATTERN, $range) === 1;
    }

    /**
     * Check whether a given value looks like a language or language range.
     */
    public static function isLanguageOrRange($language): bool
    {
        return is_string($language) and
               (preg_match(LANGUAGE_PATTERN, $language) === 1 or
               preg_match(LANGUAGE_RANGE_PATTERN, $language) === 1);
    }

    /**
     * Check whether a given value is a string.
     */
    public static function isString($string): bool
    {
        return is_string($string);
    }

    /**
     * Check whether a given value is a concept scheme
     */
    public static function isConceptScheme($scheme): bool
    {
        return $scheme instanceof ConceptScheme;
    }

    /**
     * Check whether a given value is of given type.
     */
    public static function hasType($value, string $type): bool
    {
        $method = "is$type";
        return self::$method($value);
    }
}
