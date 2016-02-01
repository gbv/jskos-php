<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Data;

/**
 * JSKOS Concept, ConceptScheme or ConceptType.
 */
abstract class LabeledRecord extends Record {
    public $type;
    
    public $identifier;
    public $url;
    
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
    public $depiction;
}

?>
