<?php declare(strict_types = 1);

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS Concept.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concepts
 */
class Concept extends Item
{
    use ConceptBundleTrait;

    const TYPES = [
        'http://www.w3.org/2004/02/skos/core#Concept'
    ];

    const FIELDS = [
        'narrower'      => ['Set', 'Concept'],
        'broader'       => ['Set', 'Concept'],
        'related'       => ['Set', 'Concept'],
        'previous'      => ['Set', 'Concept'],
        'next'          => ['Set', 'Concept'],
        'ancestors'     => ['Set', 'Concept'],
        'inScheme'      => ['Set', 'ConceptScheme'],
        'topConceptOf'  => ['Set', 'ConceptScheme'],
        'memberSet'     => ['Set', 'Concept'],
        'memberList'    => ['Set', 'Concept'], // FIXME
        'memberChoice'  => ['Set', 'Concept'],
    ];

    /**
     * Narrower concepts.
     */
    protected $narrower;

    /**
     * Broader concepts.
     */
    protected $broader;

    /**
     * Generally related concepts.
     */
    protected $related;

    /**
     * Related concepts ordered somehow before the concept.
     */
    protected $previous;

    /**
     * Related concepts ordered somehow after the concept.
     */
    protected $next;

    /**
     * List of ancestors, possibly up to a top concept.
     */
    protected $ancestors;

    /**
     * [ConceptSchemes](ConceptScheme) this concept is part of.
     */
    protected $inScheme;

    /**
     * [ConceptSchemes](ConceptScheme) this concept is top concept of.
     */
    protected $topConceptOf;
}
