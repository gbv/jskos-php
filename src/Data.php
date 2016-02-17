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
abstract class Data implements \JsonSerializable {

    /**
     * Returns data which should be serialized to JSON.
     *
     * The default data contains all non-null members and `@context`.
     * Keys are sorted by Unicode codepoint.
     */
    public function jsonSerialize() {
        $json = [
            '@context' => 'https://gbv.github.io/jskos/context.json',
        ];
        foreach ($this as $key => $value) {
            if (isset($value)) {
                $json[$key] = $value;
            }
        }
        ksort($json);
        return $json;
    }

    /**
     * Serialize to JSON in string context.
     */
    public function __toString() {
        return json_encode($this);
    }

    /**
     * Serialize to pretty-printed JSON.
     */
    public function json() {
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

?>
