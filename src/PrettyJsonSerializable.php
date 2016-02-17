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
abstract class PrettyJsonSerializable implements \JsonSerializable {

    /**
     * Returns data which should be serialized to JSON.
     *
     * Internally delegates to jsonSerializeRoot.
     */
    public function jsonSerialize() {
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
    public function jsonSerializeRoot($root=TRUE) {
        $json = [ ];
        if ($root) {
            $json['@context'] = 'https://gbv.github.io/jskos/context.json';
        }
        foreach ($this as $key => $value) {
            if (isset($value)) {
                if (is_a($value,'JSKOS\PrettyJsonSerializable')) {
                    $value = $value->jsonSerializeRoot(FALSE);
                } 
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
        return json_encode($this,  JSON_UNESCAPED_SLASHES);
    }

    /**
     * Serialize to pretty-printed JSON.
     */
    public function json() {
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

?>
