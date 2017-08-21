<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * Provide consistent JSON(-LD) serializing.
 */
abstract class PrettyJsonSerializable implements \JsonSerializable
{
    const DEFAULT_CONTEXT = 'https://gbv.github.io/jskos/context.json';

    /**
     * Returns data which should be serialized to JSON.
     *
     * Delegates to jsonLDSerialize which can be called with a JSON-LD context URL.
     */
    public function jsonSerialize()
    {
        return $this->jsonLDSerialize();
    }

    /**
     * Returns data which should be serialized to JSON.
     *
     * Include all non-null members and the JSON-LD context (`@context`).
     * Keys are sorted by Unicode codepoint for stable output.
     *
     * @param string $context optional JSON-LD context URL. Use empty string to omit.
     */
    public function jsonLDSerialize(string $context = self::DEFAULT_CONTEXT)
    {
        $json = [];

        foreach ($this as $key => $value) {
            if (isset($value)) {
                if ($value instanceof PrettyJsonSerializable) {
                    $value = $value->jsonLDSerialize('');
                } elseif (is_array($value) and !count(array_filter(array_keys($value), 'is_string'))) {
                    $a = [];
                    foreach ($value as $m) {
                        if ($m instanceof PrettyJsonSerializable) {
                            $m = $m->jsonLDSerialize('');
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
            $types = defined(get_called_class() . '::TYPES') ? static::TYPES : [];
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
        return json_encode($this, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Serialize to pretty-printed JSON.
     */
    public function json()
    {
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
