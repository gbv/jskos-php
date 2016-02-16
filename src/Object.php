<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Data;

/**
 * A JSKOS object with support of common fields.
 *
 * @todo fields are not validated yet:
 * https://github.com/gbv/jskos-php/issues/2
 *
 * @see https://gbv.github.io/jskos/jskos.html#common-fields
 */
abstract class Object extends Data {

    /**
     * Create a new JSKOS object.
     *
     * @param String|Array|Object JSON data to copy
     */
    public function __construct( $data = NULL ) {
        if (is_string($data)) {
            $data = json_decode($data);
        }
        if (is_array($data) or is_object($data)) {
            foreach ($data as $key => $value) {
                if ($key != '@context') {
                    # deep copy?
                    $this->$key = $value;
                }
            }
        } elseif ( $data !== NULL ) {
            throw new \InvalidArgumentException('argument passed to Item constructor must be string, array, or object');
        }
    }

    /**
     * Object types(s).
     *
     * @var array $type
     */
    public $type;

    /**
     * URI if the Concept, ConceptScheme, ConceptType, Mapping
     * or whatever this object refers to.  
     *
     * @var string $uri
     */
    public $uri;
    
    /**
     * Date of creation.
     *
     * @var date $created
     */
    public $created;

    /**
     * Date of last modification.
     *
     * @var date $modified
     */
    public $modified;
}

?>
