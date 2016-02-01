<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\LabeledRecord;

/**
 * A JSKOS %Concept Scheme
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-schemes
 */
class ConceptScheme extends LabeledRecord {
    /**
     * Top concepts of the concept scheme.
     * @var Set $topConcepts
     */
    public $topConcepts;
}

?>
