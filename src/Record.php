<?php
/**
 * @file
 */

namespace JSKOS;

use JSKOS\Data;

/**
 * A JSKOS record with support of common fields.
 *
 * @todo fields are not validated yet:
 * https://github.com/gbv/jskos-php/issues/2
 *
 * @see https://gbv.github.io/jskos/jskos.html#common-fields
 */
abstract class Record extends Data {

    /**
     * Create a new record.
     *
     * @param String|Array|Object JSON data or record to copy
     */
    public function __construct( $data=NULL ) {
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
        }
    }
    
    /**
     * URI if the Concept, ConceptScheme, ConceptType, ConceptMapping
     * or whatever this record refers to.  
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
