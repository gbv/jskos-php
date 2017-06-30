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

    /**
     * Check whether an equal member alredy exists in this Container.
     */
    protected function findMember($member)
    {
        return in_array($member, $this->members);
    }

    /**
     * Join List members with a string
     * @param $glue string
     */
    public function implode(string $glue): string
    {
        return implode($glue, $this->members);
    }
}
