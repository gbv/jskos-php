<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Item;

/**
 * A JSKOS %Mapping.
 *
 * @see https://gbv.github.io/jskos/jskos.html#concept-mappings
 */
class Mapping extends Object {
    
    public $from;
    public $to;

    public $fromScheme;
    public $toScheme;

    public $mappingRelevance; // experimental

    /**
     * Create a new mapping.
     *
     * @param String|Array|Object JSON data to copy
     */
    public function __construct( $data = NULL ) {
        parent::__construct($data);

        if ($this->type) {
            // TODO: check constraints!
        } else {
            $this->type = ['http://www.w3.org/2004/02/skos/core#mappingRelation'];
        }

        if (!$this->from) {
            $this->from = new ConceptBundle();
        }

        if (!$this->to) {
            $this->to = new ConceptBundle();
        }
    }
}

?>
