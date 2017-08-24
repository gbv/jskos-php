<?php declare(strict_types = 1);

namespace JSKOS;

/**
 * JSKOS Specification version aligned with.
 */
const JSKOS_SPECIFICATION = '0.1.4';

use InvalidArgumentException;

/**
 * A JSKOS resource with support of common fields.
 *
 * @see https://gbv.github.io/jskos/jskos.html#jskos-resources
 */
abstract class Resource extends DataType
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
     * or whatever this resource refers to.
     */
    protected $uri;
    
    /**
     * Resource types(s).
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
     * Agent primarily responsible for creation of resource.
     */
    protected $creator;

    /**
     * Agent responsible for making contributions to the resource.
     */
    protected $contributor;

    /**
     * Agent responsible for making the resource available.
     */
    protected $publisher;

    /**
     * Resources which this resource is part of.
     */
    protected $partOf;


	/**
	 * Guess subclass from list of type URIs.
	 */
   	static public function guessClassFromTypes(array $types) {
        if (count($types)) {
            foreach (['ConceptScheme', 'Concordance', 'Mapping', 'Concept'] as $class) {
                $class = "JSKOS\\$class";
                foreach ($class::TYPES as $uri) {
                    if (in_array($uri, $types)) {
                        return $class;
                    }
                }            
            } 
        }
    }
}
