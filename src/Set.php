<?php declare(strict_types = 1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * A JSKOS Set as defined by JSKOS specification.
 *
 * A Set is a possibly empty array with all members being JSKOS Resources
 * with distinct values in field `uri` (if given), except the last member
 * optionally being null.
 */
class Set extends Container
{
    /**
     * Check whether an equal member alredy exists in this Set.
     */
    public function contains($member): bool
    {
        return $member->uri ? !!$this->findURI($member->uri) : false;
    }

    /**
     * Return the offset of a member Resource with given URI, if it exists.
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
     * Return whether this set does not contain same resources.
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
