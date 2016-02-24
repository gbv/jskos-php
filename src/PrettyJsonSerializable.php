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

    const TYPE_URI = null;

    /**
     * Check whether a given list of types is valid for this class.
     */
    public static function validType($type)
    {
        return $type[0] == static::TYPE_URI;
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
            if (static::TYPE_URI) {
                if (isset($json['type'])) {
                    if (!static::validType($json['type'])) {
                        array_unshift($json['type'], static::TYPE_URI);
                    }
                } else {
                    $json['type'] = [static::TYPE_URI];
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
