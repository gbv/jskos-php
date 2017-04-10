<?php declare(strict_types=1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * A JSKOS List as defined by JSKOS specification.
 */
class Listing extends Container
{
    protected static function checkMember($value)
    {
        if (is_scalar($value)) {
            return "$value";
        } else {
            throw new InvalidArgumentException('JSKOS\Listing may only contain strings');
        }
    }
}
