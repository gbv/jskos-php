<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Object;

/**
 * JSKOS Concept, ConceptScheme, ConceptType, Registry, or Concordance.
 */
abstract class Item extends Object
{
    /**
     * URL of a page about the item.
     * @var date $created
     */
    public $url;

    /**
     * Additional identifiers of the item.
     * @var array $identifier
     */
    public $identifier;

    /**
     * Notations.
     * @var array $notation
     */
    public $notation;

    /**
     * Preferred labels.
     * @var array $prefLabel
     */
    public $prefLabel;

    /**
     * Alternative labels.
     * @var array $altLabel
     */
    public $altLabel;

    /**
     * Hidden labels.
     * @var array $hiddenLabel
     */
    public $hiddenLabel;

    /**
     * Scope notes.
     * @var array $scopeNote
     */
    public $scopeNote;

    /**
     * Definitions.
     * @var array $definition
     */
    public $definition;

    /**
     * Examples.
     * @var array $example
     */
    public $example;

    /**
     * History notes.
     * @var array $historyNote
     */
    public $historyNote;

    /**
     * Editorial notes.
     * @var array $editorialNote
     */
    public $editorialNote;

    /**
     * Change notes.
     * @var array $changeNote
     */
    public $changeNote;

    /**
     * Topics of the item.
     * @var Set $subject
     */
    public $subject;

    /**
     * Additional resources about the item.
     * @var Set $subjectOf
     */
    public $subjectOf;

    /**
     * Image URLs depicting the item.
     * @var Set $depiction
     */
    public $depiction;
}
