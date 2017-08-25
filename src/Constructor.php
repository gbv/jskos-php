<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * Initialize field values of a new JSKOS Object.
 */
trait Constructor
{
    /**
     * Set a field value.
     */
    abstract protected function setField(string $field, $value, bool $strict = true);

    /**
     * Create a new JSKOS object with given field values.
     *
     * @param Array|Object fields to copy
     * @param bool strict throw error on unknown fields
     */
    public function __construct($data = null, bool $strict = false)
    {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $key => $value) {
                $this->setField($key, $value, $strict);
            }
        } elseif ($data !== null) {
            throw new InvalidArgumentException(
                get_called_class() .
                ' constructor expects array, object, or null'
            );
        }

        if ($this instanceof Resource && !count($this->type ?? [])) {
            $class = get_called_class();
            if (count($class::TYPES)) {
                $this->type = new Listing([$class::TYPES[0]]);
            }
        }
    }
}
