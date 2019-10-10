<?php declare(strict_types = 1);

namespace JSKOS;

use JSKOS\Resource;

/**
 * Base class of Concept, ConceptScheme, Concordance, Registry, and AccessPoint.
 */
class Item extends Resource
{
    const FIELDS = [
        'url'           => 'URL',
        'notation'      => ['Listing'],
        'prefLabel'     => 'LanguageMapOfStrings',
        'altLabel'      => 'LanguageMapOfLists',
        'hiddenLabel'   => 'LanguageMapOfLists',
        'scopeNote'     => 'LanguageMapOfLists',
        'definition'    => 'LanguageMapOfLists',
        'example'       => 'LanguageMapOfLists',
        'historyNote'   => 'LanguageMapOfLists',
        'editorialNote' => 'LanguageMapOfLists',
        'changeNote'    => 'LanguageMapOfLists',
        'note'          => 'LanguageMapOfLists',
        'startDate'     => 'Date',
        'endDate'       => 'Date',
        'relatedDate'   => 'Date',
        'location'      => '*',
        'subject'       => ['Set', 'Concept'],
        'subjectOf'     => ['Set', 'Concept'],
        'depiction'     => ['Listing']
    ];

    /**
     * URL of a page about the item.
     */
    protected $url;

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
     * Change notes.
     */
    protected $changeNote;

    /**
     * Editorial notes.
     */
    protected $editorialNote;

    /**
     * Generic notes.
     */
    protected $note;

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

    /**
     * Date of birth, creation, or establishment.
     */
    protected $startDate;

    /**
     * Date death or resolution.
     */
    protected $endDate;

    /**
     * Other somehow related dates.
     */
    protected $relatedDate;

    /**
     * List of geographic coordinates.
     */
    protected $location;
}
