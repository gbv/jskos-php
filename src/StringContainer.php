<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * Common methods of Containers with string members (Listing, LanguageMapOfStrings).
 */
trait StringContainer
{
    /**
     * Stringify if value is a scalar, throw an expection otherwise.
     */
    protected static function checkMember($value)
    {
        if (is_scalar($value)) {
            return "$value";
        } else {
            throw new InvalidArgumentException(
                get_called_class() . ' may only contain strings'
            );
        }
    }
    
    /**
     * Check whether an equal member alredy exists in this Listing.
     */
    public function contains($member): bool
    {
        return in_array($member, $this->members);
    }
}
