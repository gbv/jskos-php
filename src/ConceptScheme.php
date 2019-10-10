<?php declare(strict_types = 1);

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS Concept Scheme.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-schemes
 */
class ConceptScheme extends Item
{
    const TYPES = [
        'http://www.w3.org/2004/02/skos/core#ConceptScheme'
    ];

    const FIELDS = [
        'topConcepts' => ['Set', 'Concept'],
        'versionOf'   => ['Set', 'ConceptScheme'],
        'namespace'   => 'string',
        'uriPattern'  => 'string',
        'notationPattern' => 'string',
        'concepts'    => ['Set', 'AccessPoint'], // TODO
        'types'       => ['Set', 'AccessPoint'], // TODO
        'distributions' => ['Set', 'Concept'],
        'extent'      => 'string',
        'languages'   => ['Listing'],
        'license'     => ['Set', 'Concept'],
    ];

    /**
     * Top concepts of the concept scheme.
     */
    protected $topConcepts;

    /**
     * [ConceptSchemes](ConceptScheme) this concept scheme is a version or edition of.
     */
    protected $versionOf;

    protected $namespace;
    protected $uriPattern;
    protected $notationPattern;

    /**
     * AccessPoints to concepts in this scheme.
     */
    protected $concepts;

    /**
     * AccessPoints to Types in this scheme.
     */
    protected $types;

    protected $distributions;

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
