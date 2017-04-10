<?php declare(strict_types=1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * A JSKOS Set as defined by JSKOS specification.
 *
 * A Set is a possibly empty array with all members being JSKOS Objects
 * with distinct values in field `uri` (if given), expect the last member
 * optionally being null.
 */
class Set extends Container
{
    protected static function checkMember($value)
    {
        if (is_a($value, 'JSKOS\Object')) {
            return $value;
        } else {
            throw new InvalidArgumentException('JSKOS\Set may only contain JSKOS Objects');
        }
    }

    /**
     * Return the offset of a member Object with given URI, if it exists.
     */
    public function findURI(string $uri)
    {
        foreach ($this->members as $member) {
            if ($member->uri == $uri) {
                return $member;
            }
        }
    }

    /**
     * Return whether this set does not contain same objects.
     */
    public function isValid()
    {
        $uris = [];
        foreach ($this->members as $member) {
            $uri = $member->uri;
            if ($uri) {
                if (isset($uris[$uri])) {
                    return false;
                } else {
                    $uris[$uri] = true;
                }
            }
        }
        return true;
    }
}
