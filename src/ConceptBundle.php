<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Concept Bundle.
 *
 * %Concept bundles are used as part of Mappings.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-bundles
 */
class ConceptBundle extends Data {

    /**
     * Concepts in this bundle.
     * @var Set $members
     */
    public $members = [];

    /**
     * Whether the concept in this bundle are ordered (list) or not (set).
     * @var boolean $ordered
     */
    public $ordered = FALSE;

    /**
     * Whether the concepts in this bundle are combined by OR instead of AND.
     * @var boolean $disjunction
     */
    public $disjunction = FALSE;

    /**
     * Returns data which should be serialized to JSON.
     */
    public function jsonSerialize() {
        $json = [ 'members' => $this->members ];
        if ($this->ordered) $json['ordered'] = TRUE;
        if ($this->disjunction) $json['disjunction'] = TRUE;
        return $json;
    }

}

?>
