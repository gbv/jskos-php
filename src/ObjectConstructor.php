<?php declare(strict_types=1);

namespace JSKOS;

use InvalidArgumentException;

trait ObjectConstructor
{
    /**
     * Create a new JSKOS object.
     *
     * @param Array|Object JSON data to copy
     */
    public function __construct($data=null, bool $strict=false)
    {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $key => $value) {
                $this->setField($key, $value, $strict);
            }
        } elseif ($data !== null) {
            throw new InvalidArgumentException(
                get_called_class() .
                ' constructor expects array, object, or JSON string'
            );
        }
    }
}
