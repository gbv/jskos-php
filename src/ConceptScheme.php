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

    /**
     * @var Set $versionOf
     */
    public $versionOf;

    /**
     * JSKOS API concepts endpoint returning all concepts in this scheme.
     * @see ServiceEndpoint
     * @var URL $concepts
     */
    public $concepts;

    /**
     * JSKOS API concepts endpoint returning all types in this scheme.
     * @see ServiceEndpoint
     * @var URL $types
     */
    public $types;
}

?>
