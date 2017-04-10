<?php declare(strict_types=1);

namespace JSKOS;

/**
 * JSKOS Specification version aligned with.
 */
const JSKOS_SPECIFICATION = '0.1.2';


use JSKOS\PrettyJsonSerializable;

/**
 * A JSKOS object with support of common fields.
 *
 * @todo fields are not validated yet:
 * https://github.com/gbv/jskos-php/issues/2
 *
 * @see https://gbv.github.io/jskos/jskos.html#jskos-objects
 */
abstract class Object extends PrettyJsonSerializable
{
 
    /**
     * Create a new JSKOS object.
     *
     * @param String|Array|Object JSON data to copy
     */
    public function __construct($data = null)
    {
        if (is_string($data)) {
            $data = json_decode($data);
        }
        if (is_array($data) or is_object($data)) {
            foreach ($data as $key => $value) {
                if ($key == '@context') {
                    // ignore
                } else {
                    # TODO: deep copy?
                    $this->$key = $value;
                }
            }
        } elseif ($data !== null) {
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
     * @var Set $creator
     */
    public $creator;

    /**
     * Agent responsible for making contributions to the object.
     *
     * @var Set $contributor
     */
    public $contributor;

    /**
     * Agent responsible for making the object available.
     *
     * @var Set $publisher
     */
    public $publisher;

    /**
     * Resources which this object is part of.
     *
     * @var Set $partOf
     */
    public $partOf;
}
