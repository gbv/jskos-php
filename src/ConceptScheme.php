<?php declare(strict_types=1);

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Concept Scheme
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-schemes
 */
class ConceptScheme extends Item
{
    const TYPES = [
        'http://www.w3.org/2004/02/skos/core#ConceptScheme'
    ];

    const FIELDS = [
        'topConcepts' => ['Set','Concept'],
        'versionOf'   => ['Set','ConceptScheme'],
        # TODO: concepts, types
        'extent'      => 'string',
        'languages'   => ['Listing'],
        'license'     => ['Set','Concept'],
    ];

    /**
     * Top concepts of the concept scheme.
     */
    protected $topConcepts;

    /**
     * [ConceptSchemes](ConceptScheme) this concept scheme is a version or edition of.
     */
    protected $versionOf;

    /**
     * JSKOS API concepts endpoint returning all concepts in this scheme.
     * @see Service
     */
    public $concepts;

    /**
     * JSKOS API concepts endpoint returning all types in this scheme.
     * @see Service
     */
    public $types;

    /**
     * Size of the concept scheme.
     */
    protected $extent;

    /**
     * Supported languages, given as array of language codes.
     */
    protected $languages;

    /**
     * License which the concept scheme is published under.
     */
    protected $license;
}
