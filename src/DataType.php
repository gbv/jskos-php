<?php declare(strict_types = 1);

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

/**
 * Base class of JSKOS Resources and fields.
 */
abstract class DataType extends PrettyJsonSerializable
{
    use Constructor;

    const FIELDS = [];

    /**
     * Get field definition from FIELDS, including parent classes.
     */
    protected static function fieldType(string $field, bool $strict=false)
    {
        $class = get_called_class();
        while ($class && $class != self::class) {
            if (isset($class::FIELDS[$field])) {
                return $class::FIELDS[$field];
            }
            $class = get_parent_class($class);
        }

        if ($strict) {
            throw new InvalidArgumentException(
                get_called_class() . "->$field does not exist"
            );
        }
    }

    private function fieldException($field, $message)
    {
        return new InvalidArgumentException(
            get_called_class()."->$field must $message"
        );
    }

    protected function setField(string $field, $value, bool $strict=true)
    {
        if ($field == '@context') {
            return;
        }

        $type = static::fieldType($field, $strict);
        if (!$type) {
            return;
        }

        if (is_null($value)) {
            $value = null;
        } elseif (is_array($type)) { # Set or Listing
            if ($type[0] == 'Set') {
                if (!($value instanceof Set)) {
                    if (is_array($value)) {
                        $class = 'JSKOS\\'.$type[1];
                        $value = new Set(
                            array_map(function ($m) use ($class) {
                                if (is_null($m)) {
                                    return null;
                                }
                                if ($m instanceof $class) {
                                    return $m;
                                }
                                return new $class($m);
                            }, $value)
                        );
                    } else {
                        throw $this->fieldException($field, "be a Set");
                    }
                }
                # TODO: check member types
            } else { # Listing
                if (!($value instanceof Listing)) {
                    if (is_array($value)) {
                        $value = new Listing($value);
                    } else {
                        throw $this->fieldException($field, "be a Listing");
                    }
                }
                # TODO: check member types
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
                throw $this->fieldException($field, "match JSKOS\DataType::is$type");
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
        return is_string($uri) && preg_match(IRI_PATTERN, $uri) === 1;
    }

    /**
     * Check whether a given value looks like an http/https URL.
     */
    public static function isURL($url): bool
    {
        return is_string($url) &&
               preg_match(IRI_PATTERN, $url, $match) &&
               ($match[2] == 'http' || $match[2] == 'https');
    }

    /**
     * Check whether a given value looks like a date.
     */
    public static function isDate($date): bool
    {
        return is_string($date) && preg_match(DATE_PATTERN, $date) === 1;
    }

    /**
     * Check whether a given value looks like a language tag.
     */
    public static function isLanguage($language): bool
    {
        return is_string($language) && preg_match(LANGUAGE_PATTERN, $language) === 1;
    }

    /**
     * Check whether a given value looks like a language range.
     */
    public static function isLanguageRange($range): bool
    {
        return is_string($range) && preg_match(LANGUAGE_RANGE_PATTERN, $range) === 1;
    }

    /**
     * Check whether a given value looks like a language or language range.
     */
    public static function isLanguageOrRange($language): bool
    {
        return is_string($language) &&
               (preg_match(LANGUAGE_PATTERN, $language) === 1 ||
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
