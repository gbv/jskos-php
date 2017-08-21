<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * Language map of strings for prefLabel.
 */
class LanguageMapOfStrings extends LanguageMap
{
    protected static function checkMember($value)
    {
        if (is_scalar($value)) {
            return "$value";
        } else {
            throw new InvalidArgumentException(
                'JSKOS\LanguageMapOfStrings may only contain strings'
            );
        }
    }

    /**
     * Return a data structure to serialize this container as JSON.
     */
    public function jsonLDSerialize(string $context = self::DEFAULT_CONTEXT)
    {
        return (object)$this->members;
    }
}
