<?php
/**
 * PHP library to process JSKOS data.
 *
 * This library implements classes for JSKOS Concepts, Concept Schemes,
 * Concept Types, and Concept Mappings.
 *
 * @code
 * <?php
 * require_once('JSKOS/Data.php');
 *
 * my $concept = new \JSKOS\Concept();
 * $concept->uri = "http://example.org/";
 * echo json_encode($concept);
 * ...
 * ?>
 * @endcode
 *
 * @see https://gbv.github.io/jskos/
 *
 * @file
 */

namespace JSKOS;

/**
 * Any JSON based object in JSKOS or JSKOS API.
 *
 * Can always be serialized as JSON via json_encode.
 */
abstract class Data implements \JsonSerializable {

    /**
     * Returns data which should be serialized to JSON.
     *
     * The default data contains all non-null members and `@context`.
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
    public function pretty() {
        return json_encode($this, JSON_PRETTY_PRINT);
    }
}

?>
