<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Concept Scheme
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-schemes
 */
class ConceptScheme extends Item
{

    /**
     * Returns an array with the type URI of all concept schemes.
     */
    public static function primaryTypes()
    {
        return ['http://www.w3.org/2004/02/skos/core#ConceptScheme'];
    }

    /**
     * Top concepts of the concept scheme.
     * @var Set $topConcepts
     */
    public $topConcepts;

    /**
     * [ConceptSchemes](ConceptScheme) this concept scheme is a version or edition of.
     * @var Set $versionOf
     */
    public $versionOf;

    /**
     * JSKOS API concepts endpoint returning all concepts in this scheme.
     * @see Service
     * @var URL $concepts
     */
    public $concepts;

    /**
     * JSKOS API concepts endpoint returning all types in this scheme.
     * @see Service
     * @var URL $types
     */
    public $types;

    /**
     * Supported languages, given as array of language codes.
     * @var array $languages
     */
    public $languages;

    /**
     * License which the concept scheme is published under.
     *
     * @var Set $license
     */
    public $license;
}
