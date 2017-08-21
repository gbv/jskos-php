<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * Language map of strings for prefLabel.
 */
class LanguageMapOfStrings extends LanguageMap
{
    use StringContainer;

    /**
     * Return a data structure to serialize this container as JSON.
     */
    public function jsonLDSerialize(string $context = self::DEFAULT_CONTEXT)
    {
        return (object)$this->members;
    }
}
