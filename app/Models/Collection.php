<?php

declare(strict_types=1);

namespace App\Models;

class Collection implements \ArrayAccess, \Countable, \Iterator
{
    public function __construct(private readonly string $entityClass, public array $items = [])
    {
        $this->items = [];

        foreach ($items as $item)
            $this->add($item);
    }

    public function add($item): void
    {
        if (!($item instanceof $this->entityClass))
            throw new \InvalidArgumentException("Invalid object provided. Expected: " . $this->entityClass);

        $this->items[] = $item;
    }

    public function offsetSet($key, $item): void
    {
        if (!($item instanceof $this->entityClass)) {
            throw new \InvalidArgumentException("Invalid object provided. Expected: " . $this->entityClass);
        }
        if ($key === null) {
            $this->items[] = $item;
        } else {
            $this->items[$key] = $item;
        }
    }

    public function offsetUnset($key): void
    {
        if (\array_key_exists($key, $this->items)) {
            unset($this->items[$key]);
        }
    }

    public function offsetGet($key)
    {
        if (\array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }
        return null;
    }

    public function offsetExists($key): bool
    {
        return \array_key_exists($key, $this->items);
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function rewind(): void
    {
        \reset($this->items);
    }

    public function current()
    {
        return \current($this->items);
    }

    public function next(): void
    {
        \next($this->items);
    }

    public function key()
    {
        return \key($this->items);
    }

    public function valid(): bool
    {
        return (bool)$this->current();
    }

    public function count(): int
    {
        return \count($this->items);
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        $first = \reset($this->items);

        return false == $first ? null : $first;
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        $last = \end($this->items);

        return false === $last ? null : $last;
    }

    public function filter(callable $callback, int $mode = 0): Collection
    {
        $copy = clone $this;
        $copy->items = \array_filter($this->items, $callback, $mode);

        return $copy;
    }

    public function reduce(callable $callback, $initial = null)
    {
        return \array_reduce($this->items, $callback, $initial);
    }
}
