<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\LabeledRecord;

/**
 * A JSKOS %Concept.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concepts
 */
class Concept extends LabeledRecord {
    public $inScheme;
    public $topConceptOf;
    public $subjectOf;

    public $narrower; 
    public $broader; 
    public $ancestors;
    public $related; 
    public $previous;
    public $next;

    public $startDate;
    public $endDate;
    public $relatedDate;
}

?>
