<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;
use TypeError;

/**
 * Language map of lists for labels and notes.
 */
class LanguageMapOfLists extends LanguageMap
{
    protected static function checkMember($value)
    {
        if ($value instanceof Listing) {
            return $value;
        } else {
            try {
                return new Listing($value);
            } catch (TypeError $e) {
                throw new InvalidArgumentException(
                    'JSKOS\LanguageMapOfLists may only contain JSKOS\Listing'
                );
            }
        }
    }

    /**
     * Return a data structure to serialize this container as JSON.
     */
    public function jsonLDSerialize(string $context = self::DEFAULT_CONTEXT)
    {
        $map = new \stdClass();
        foreach ($this->members as $lang => $list) {
            $map->$lang = $list->jsonLDSerialize('');
        }
        return $map;
    }
}
