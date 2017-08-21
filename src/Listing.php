<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * A JSKOS List as defined by JSKOS specification.
 */
class Listing extends Container
{
    use StringContainer;

    /**
     * Join List members with a string
     * @param $glue string
     */
    public function implode(string $glue): string
    {
        return implode($glue, $this->members);
    }
}
