<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Concept Mapping.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-mappings
 */
class ConceptMapping extends Object {
    public $from;
    public $to;
    public $sourceScheme;
    public $targetScheme;
    public $mappingRelevance; // experimental
}

?>
