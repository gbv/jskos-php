<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Object;

/**
 * JSKOS Concept, ConceptScheme, ConceptType, Registry, or Concordance.
 */
abstract class Item extends Object {
    public $url;
    public $identifier;
    
    public $notation;

    public $prefLabel;
    public $altLabel;
    public $hiddenLabel;

    public $scopeNote;
    public $definition;
    public $example;
    public $historyNote;
    public $editorialNote;
    public $changeNote;

    public $subject;
    public $depiction;
}

?>
