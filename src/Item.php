<?php declare(strict_types=1);

namespace JSKOS;

use JSKOS\Object;

/**
 * JSKOS Concept, ConceptScheme, ConceptType, Registry, or Concordance.
 */
abstract class Item extends Object
{
    const FIELDS = [
        'url'           => 'URL',
        'identifier'    => ['Listing'],
        'notation'      => ['Listing'],
        # TODO: labels and descriptions
        'subject'       => ['Set','Concept'],
        'subjectOf'     => ['Set','Concept'],
        'depiction'     => ['Listing'],
    ];

    /**
     * URL of a page about the item.
     */
    protected $url;

    /**
     * Additional identifiers of the item.
     */
    protected $identifier;

    /**
     * Notations.
     */
    protected $notation;

    /**
     * Preferred labels.
     */
    public $prefLabel;

    /**
     * Alternative labels.
     */
    public $altLabel;

    /**
     * Hidden labels.
     */
    public $hiddenLabel;

    /**
     * Scope notes.
     */
    public $scopeNote;

    /**
     * Definitions.
     */
    public $definition;

    /**
     * Examples.
     */
    public $example;

    /**
     * History notes.
     */
    public $historyNote;

    /**
     * Editorial notes.
     */
    public $editorialNote;

    /**
     * Change notes.
     */
    public $changeNote;

    /**
     * Topics of the item.
     */
    protected $subject;

    /**
     * Additional resources about the item.
     */
    protected $subjectOf;

    /**
     * Image URLs depicting the item.
     */
    protected $depiction;
}
