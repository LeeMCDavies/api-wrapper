<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 21/09/2020
 * Time: 09:06
 */

namespace Pecyn\ApiWrapper;

use Pecyn\ApiWrapper\Exceptions\InvalidCollectionValue;

abstract class Collection implements Interfaces\Collection
{
    protected $objects = [];

    public function __construct(array $objects = [])
    {
        foreach ($objects as $ob) {
            $this[] = $ob;
        }
    }

    public function count()
    {
        return count($this->objects);
    }

    public function offsetExists($offset)
    {
        return isset($this->objects[$offset]);
    }


    public function offsetSet($offset, $value)
    {
        if (!$this->validate($value)) {
            throw new InvalidCollectionValue('Invalid collection value', '400');
        }
        if (is_null($offset)) {
            $this->objects[] = $value;
        } else {
            $this->objects[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->objects[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->objects[$offset]) ? $this->objects[$offset] : null;
    }

    public function current()
    {
        return current($this->objects);
    }

    public function next()
    {
        return next($this->objects);
    }

    public function key()
    {
        return key($this->objects);
    }

    public function valid()
    {
        return key($this->objects) !== null;
    }

    public function rewind()
    {
        reset($this->objects);
    }

    public function uniqueValues(): array
    {
        return array_unique($this->objects);
    }
}
