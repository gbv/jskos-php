<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * Language map of strings for prefLabel.
 */
class LanguageMapOfStrings extends LanguageMap
{
    use StringContainer;

    public function jsonLDSerialize(string $context = self::DEFAULT_CONTEXT, bool $types = null)
    {
        return (object)$this->members;
    }
}
