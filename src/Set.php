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
     * Check whether an equal member already exists in this Set.
     */
    public function contains($member): bool
    {
        return $member instanceof Resource && $member->uri &&
            $this->findURI($member->uri) >= 0;
    }

    /**
     * Return the offset of a member Resource with given URI or -1.
     */
    public function findURI(string $uri)
    {
        foreach ($this->members as $offset => $member) {
            if ($member->uri == $uri) {
                return $offset;
            }
        }
        return -1;
    }

    /**
     * Return whether this set does not contain same resources.
     */
    public function isValid(): bool
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
