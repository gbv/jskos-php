<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\LabeledRecord;

/**
 * A JSKOS %Concept Mapping.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-mappings
 */
class ConceptMapping extends Record {
    public $mappingType;
    public $mappingRelevance; // experimental
    public $from;
    public $to;
    public $sourceScheme;
    public $targetScheme;
}

?>
