<?php declare(strict_types=1);

namespace JSKOS;

use InvalidArgumentException;

/**
 * Common base class of JSKOS Listings and Sets
 */
abstract class Container extends PrettyJsonSerializable implements \Countable, \ArrayAccess, \IteratorAggregate
{
    protected $members = [];
    protected $closed  = true;

    abstract protected static function checkMember($member);

    public function __construct(array $members = [])
    {
        foreach ($members as $m) {
            if (is_null($m)) {
                $this->closed = false;
            } else {
                $this->members[] = static::checkMember($m);
            }
        }
    }

    /**
     * Return the number of known values in this container (closed or not).
     */
    public function count(): int
    {
        return count($this->members);
    }

    /**
     * Apply a function to each member of this container.
     * @param $callback callable
     */
    public function map(callable $callback): array
    {
        $result = [];

        foreach ($this->members as $member) {
            $result[] = $callback($member);
        }

        return $result;
    }

    /**
     * Return whether this container is empty (no members and closed).
     */
    public function isEmpty(): bool
    {
        return $this->closed && !count($this->members);
    }

    /**
     * Return whether this container is closed.
     */
    public function isClosed(): bool
    {
        return $this->closed;
    }

    /**
     * Set whether this container is closed (no unknown members) or not.
     * @param Boolean $closed
     */
    public function setClosed(bool $closed = true)
    {
        $this->closed = $closed;
    }

    # implements ArrayAccess:

    /**
     * Return whether an object exists at the given offset.
     * @param mixed $offset
     */
    public function offsetExists($offset)
    {
        return isset($this->members[$offset]);
    }

    /**
     * Return an object at the given offset.
     * @param mixed $offset
     */
    public function offsetGet($offset)
    {
        return $this->members[$offset];
    }

    /**
     * Set an object at the given offset.
     * @param mixed $offset
     * @param mixed $object
     */
    public function offsetSet($offset, $object)
    {
        if (is_int($offset) && $offset >= 0 && $offset < $this->count()) {
            $this->members[$offset] = static::checkMember($object);
        } elseif (is_null($object)) {
            $this->closed = false;
        } else {
            $this->members[] = static::checkMember($object);
        }
    }

    /**
     * @throws \BadMethodCallException
     */
    public function offsetUnset($key)
    {
        throw new \BadMethodCallException(__METHOD__ . ' is not supported');
    }

    # implements IteratorAggregate:

    /**
     * Return an iterator to iterate all members of the set.
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->members);
    }

    # extends PrettyJsonSerializable:

    /**
     * Return a data structure to serialize this container as JSON.
     */
    public function jsonSerializeRoot($context=self::DEFAULT_CONTEXT)
    {
        $set = array_map(function ($m) {
            return is_object($m) ? $m->jsonSerializeRoot(null) : $m;
        }, $this->members);

        if (!$this->closed) {
            $set[] = null;
        }
        return $set;
    }
}
