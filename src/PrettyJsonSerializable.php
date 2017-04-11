<?php declare(strict_types=1);
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
    const DEFAULT_CONTEXT = 'https://gbv.github.io/jskos/context.json';

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
     * @param string $context
     */
    public function jsonSerializeRoot($context=self::DEFAULT_CONTEXT)
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

        if ($context) {
            $json['@context'] = $context;
            $types = defined(get_called_class().'::TYPES') ? static::TYPES : [];
            if (property_exists($this, 'type') and count($types)) {
                if (isset($json['type'])) {
                    if (empty(array_intersect($json['type'], $types))) {
                        array_unshift($json['type'], $types[0]);
                    }
                } else {
                    $json['type'] = [$types[0]];
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
