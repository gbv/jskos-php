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
        'prefLabel'     => 'LanguageMapOfStrings',
        'altLabel'      => 'LanguageMapOfLists',
        'hiddenLabel'   => 'LanguageMapOfLists',
        'scopeNote'     => 'LanguageMapOfLists',
        'definition'    => 'LanguageMapOfLists',
        'example'       => 'LanguageMapOfLists',
        'historyNote'   => 'LanguageMapOfLists',
        'changeNote'    => 'LanguageMapOfLists',
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
    protected $prefLabel;

    /**
     * Alternative labels.
     */
    protected $altLabel;

    /**
     * Hidden labels.
     */
    protected $hiddenLabel;

    /**
     * Scope notes.
     */
    protected $scopeNote;

    /**
     * Definitions.
     */
    protected $definition;

    /**
     * Examples.
     */
    protected $example;

    /**
     * History notes.
     */
    protected $historyNote;

    /**
     * Editorial notes.
     */
    protected $editorialNote;

    /**
     * Change notes.
     */
    protected $changeNote;

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
