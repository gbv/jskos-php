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
}

abstract class CommonFields extends Data {
    public $uri;
    public $created;
    public $modified;
}

/**
 * A JSKOS %Concept.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concepts
 */
class Concept extends CommonFields {
}

/**
 * A JSKOS %Concept Scheme
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-schemes
 */
class ConceptScheme extends CommonFields {
}

/**
 * A JSKOS %Concept or %Concept Type.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-types
 */
class ConceptType extends CommonFields {
}

/**
 * A JSKOS %Concept Mapping.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-mappings
 */
class ConceptMapping extends CommonFields {
}

?>
