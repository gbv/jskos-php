<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\PrettyJsonSerializable;

/**
 * A JSKOS object with support of common fields.
 *
 * @todo fields are not validated yet:
 * https://github.com/gbv/jskos-php/issues/2
 *
 * @see https://gbv.github.io/jskos/jskos.html#jskos-objects
 */
abstract class Object extends PrettyJsonSerializable {

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
                    # TODO: deep copy?
                    $this->$key = $value;
                }
            }
        } elseif ( $data !== NULL ) {
            throw new \InvalidArgumentException('argument passed to Item constructor must be string, array, or object');
        }
    }

    /**
     * URI if the Concept, ConceptScheme, ConceptType, Mapping
     * or whatever this object refers to.  
     *
     * @var string $uri
     */
    public $uri;
    
    /**
     * Object types(s).
     *
     * @var array $type
     */
    public $type;

    /**
     * Date of creation.
     *
     * @var date $created
     */
    public $created;

    /**
     * Date of publication.
     *
     * @var date $issued
     */
    public $issued;

    /**
     * Date of last modification.
     *
     * @var date $modified
     */
    public $modified;

    /**
     * Agent primarily responsible for creation of object.
     *
     * @var array $creator
     */
    public $creator;

    /**
     * Agent responsible for making contributions to the object.
     *
     * @var array $contributor
     */
    public $contributor;

    /**
     * Agent responsible for making the object available.
     *
     * @var array $publisher
     */
    public $publisher;

}

?>
