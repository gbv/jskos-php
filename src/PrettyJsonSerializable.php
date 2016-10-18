<?php
/**
 * PHP library to process JSKOS data.
 *
 * @see https://gbv.github.io/jskos/
 *
 * @file
 */

namespace JSKOS;

/**
 * Adds consistent JSON serializing via `json_encode` and `->json()`.
 */
abstract class PrettyJsonSerializable implements \JsonSerializable
{

    /**
     * Return a list of primary types of this class.
     */
    public static function primaryTypes()
    {
        return [];
    }

    /**
     * Return the default type of this class or null.
     */
    public static function defaultType()
    {
        $types = static::primaryTypes();
        return $types[0];
    }


    /**
     * Returns data which should be serialized to JSON.
     *
     * Internally delegates to jsonSerializeRoot.
     */
    public function jsonSerialize()
    {
        return $this->jsonSerializeRoot();
    }

    /**
     * Returns data which should be serialized to JSON.
     *
     * The default data contains all non-null members and `@context`.
     * Keys are sorted by Unicode codepoint.
     *
     * @param boolean $root
     */
    public function jsonSerializeRoot($root=true)
    {
        $json = [ ];

        foreach ($this as $key => $value) {
            if (isset($value)) {
                if (is_a($value, 'JSKOS\PrettyJsonSerializable')) {
                    $value = $value->jsonSerializeRoot(false);
                } elseif (is_array($value) and !count(array_filter(array_keys($value), 'is_string'))) {
                    $a = [];
                    foreach ($value as $m) {
                        if (is_a($m, 'JSKOS\PrettyJsonSerializable')) {
                            $m = $m->jsonSerializeRoot(false);
                        }
                        $a[] = $m;
                    }
                    $value = $a;
                }
                $json[$key] = $value;
            }
        }

        if ($root) {
            $json['@context'] = 'https://gbv.github.io/jskos/context.json';
            $types = $this->primaryTypes();
            if (count($types)) {
                if (isset($json['type'])) {
                    if (empty(array_intersect($json['type'], $types))) {
                        array_unshift($json['type'], $this->defaultType());
                    }
                } else {
                    $json['type'] = [$this->defaultType()];
                }
            }
        }

        ksort($json);
        return $json;
    }

    /**
     * Serialize to JSON in string context.
     */
    public function __toString()
    {
        return json_encode($this,  JSON_UNESCAPED_SLASHES);
    }

    /**
     * Serialize to pretty-printed JSON.
     */
    public function json()
    {
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
