<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

class AlwaysMissingArray implements \ArrayAccess, \Countable
{
    /**
     * @var array
     */
    private $storage = [];

    public function count(): int
    {
        return count($this->storage);
    }

    public function offsetExists($offset): bool
    {
        return false;
    }

    public function offsetGet($offset)
    {
        return $this->storage[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->storage[] = $value;
        } else {
            $this->storage[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->storage[$offset]);
    }
}
