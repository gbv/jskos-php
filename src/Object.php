<?php declare(strict_types=1);

namespace JSKOS;

/**
 * JSKOS Specification version aligned with.
 */
const JSKOS_SPECIFICATION = '0.1.4';

use InvalidArgumentException;

/**
 * A JSKOS object with support of common fields.
 *
 * @see https://gbv.github.io/jskos/jskos.html#jskos-objects
 */
abstract class Object extends DataType
{
    const TYPES = [];

    const FIELDS = [
        'uri'         => 'URI',
        'type'        => ['Listing'],
        'created'     => 'Date',
        'issued'      => 'Date',
        'modified'    => 'Date',
        'creator'     => ['Set','Concept'],
        'contributor' => ['Set','Concept'],
        'publisher'   => ['Set','Concept'],
        'partOf'      => ['Set','Concept'],
    ];

    /**
     * URI if the Concept, ConceptScheme, ConceptType, Mapping
     * or whatever this object refers to.
     */
    protected $uri;
    
    /**
     * Object types(s).
     */
    protected $type;

    /**
     * Date of creation.
     */
    protected $created;

    /**
     * Date of protectedation.
     */
    protected $issued;

    /**
     * Date of last modification.
     */
    protected $modified;

    /**
     * Agent primarily responsible for creation of object.
     */
    protected $creator;

    /**
     * Agent responsible for making contributions to the object.
     */
    protected $contributor;

    /**
     * Agent responsible for making the object available.
     */
    protected $publisher;

    /**
     * Resources which this object is part of.
     */
    protected $partOf;
}
