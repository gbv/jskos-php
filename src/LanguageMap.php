<?php declare(strict_types=1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * Language map of strings or lists.
 */
abstract class LanguageMap extends Container
{
    use ObjectConstructor;

    protected function setField($key, $value, $strict)
    {
        try {
            $this->offsetSet($key, $value);
        } catch (InvalidArgumentException $e) {
            if ($strict) {
                throw $e;
            }
        }
    }

    /**
     * Language maps are always closed world, so this does nothing.
     * @param Boolean $closed
     */
    public function setClosed(bool $closed = true)
    {
    }

    /**
     * Set an value at the given language or language range.
     * @param mixed $lang
     * @param mixed $value
     */
    public function offsetSet($lang, $value)
    {
        if (DataType::isLanguageOrRange($lang)) {
            if (is_null($value)) {
                unset($this->members[$lang]);
            } else {
                $this->members[$lang] = static::checkMember($value);
            }
        } else {
            throw new InvalidArgumentException(
                'JSKOS\LanguageMap may only use language tags or ranges as index'
            );
        }
    }

    /**
     * Unset a value with given language or language range.
     * @param mixed $lang
     */
    public function offsetUnset($lang)
    {
        unset($this->members[$lang]);
    }
}
