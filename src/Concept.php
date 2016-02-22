<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Concept.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concepts
 */
class Concept extends Item {

    /**
     * Default type URI of all concepts.
     */
    const TYPE_URI = 'http://www.w3.org/2004/02/skos/core#Concept'; 

    /**
     * Narrower concepts.
     * @var Set $narrower
     */
    public $narrower; 

    /**
     * Broader concepts.
     * @var Set $broader
     */
    public $broader; 

    /**
     * Generally related concepts.
     * @var Set $related
     */
    public $related; 

    /**
     * Related concepts ordered somehow before the concept.
     * @var Set $previous
     */
    public $previous;

    /**
     * Related concepts ordered somehow after the concept.
     * @var Set $next
     */
    public $next;

    /**
     * Date of birth, creation, or estabishment of what the concept is about.
     * @var string $startDate
     */
    public $startDate;

    /**
     * Date death or resolution of what the concept is about.
     * @var string $endDate
     */
    public $endDate;

    /**
     * Other date somehow related to what the concept is about.
     * @var string $relatedDate
     */
    public $relatedDate;

    /**
     * List of ancestors, possibly up to a top concept.
     * @var Set $ancestors
     */
    public $ancestors;

    /**
     * [ConceptSchemes](ConceptScheme) this concept is part of.
     * @var Set $inScheme
     */
    public $inScheme;

    /**
     * [ConceptSchemes](ConceptScheme) this concept is top concept of.
     * @var Set $topConceptOf
     */
    public $topConceptOf;

}

?>
