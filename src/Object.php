<?php declare(strict_types=1);

namespace JSKOS;

/**
 * JSKOS Specification version aligned with.
 */
const JSKOS_SPECIFICATION = '0.1.2';

use InvalidArgumentException;
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
    protected static $fields = [
        'type'          => 'Listing',
        'creator'       => ['Concept'],
        'contributor'   => ['Concept'],
        'publisher'     => ['Concept'],
        'partOf'        => ['Concept'],
    ];

    public static function fieldType(string $field)
    {
        $class = get_called_class();
        do {
            if (isset($class::$fields[$field])) {
                return $class::$fields[$field];
            }
            if ($class == Object::class) {
                return;
            }
            $class = get_parent_class($class);
        } while ($class);
    }

    public function __set($field, $value)
    {
        $type = static::fieldType($field);

        if (!$type) {
            $type = property_exists($this, $field) ? 'scalar' : null;
        }
        if (!$type) {
            $error = 'does not exist';
            throw new InvalidArgumentException(get_class() . "->$field $error");
        }

        if (is_array($type)) { # Set
            if (is_array($value)) {
                $class = 'JSKOS\\'.$type[0];
                $value = new Set(
                    array_map(function ($m) use ($class) {
                        return (is_object($m) and is_a($m, $class)) ? $m : new $class($m);
                    }, $value)
                );
            } else { #elseif (!is_object($value) or !is_a($value, 'JSKOS\Set')) {
                # TODO: check member types
            }
        } elseif ($type == 'Listing') {
            if (is_array($value)) {
                $value = new Listing($value);
            } else {
                # TODO: check
            }
        } else {
            # TODO: scalar types
        }

        $this->$field = $value;
    }

    public function __get($field)
    {
        $type = static::fieldType($field);
        return $type ? $this->$field : null;
    }

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
                if ($key != '@context') {
                    $this->__set($key, $value);
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
    protected $type;

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
