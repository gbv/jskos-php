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
class Mapping extends Object
{
    
    /**
     * Returns an array with primary type URIs of all mappings.
     */
    public static function primaryTypes()
    {
        return [
            'http://www.w3.org/2004/02/skos/core#mappingRelation',
            'http://www.w3.org/2004/02/skos/core#closeMatch',
            'http://www.w3.org/2004/02/skos/core#exactMatch',
            'http://www.w3.org/2004/02/skos/core#broadMatch',
            'http://www.w3.org/2004/02/skos/core#narrowMatch',
            'http://www.w3.org/2004/02/skos/core#relatedMatch',
        ];
    }

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
    public function __construct($data = null)
    {
        parent::__construct($data);

        if (!$this->from) {
            $this->from = new ConceptBundle();
        }

        if (!$this->to) {
            $this->to = new ConceptBundle();
        }
    }
}
