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

    public function contains($member): bool
    {
        foreach ($this->members as $list) {
            if ($list->contains($member)) {
                return true;
            }
        }
        return false;
    }

    public function jsonLDSerialize(string $context = self::DEFAULT_CONTEXT, bool $types = null)
    {
        ksort($this->members);
        $map = new \stdClass();
        foreach ($this->members as $lang => $list) {
            $map->$lang = $list->jsonLDSerialize('', $types);
        }
        return $map;
    }
}
