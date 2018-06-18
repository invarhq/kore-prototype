<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Utils;

use ArrayIterator;

/**
 * Trait FluentTrait
 * @package Kore\Utils
 */
trait FluentTrait
{
    /**
     * All of the attributes set on the container.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Clear attributes
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * @param array $data
     */
    public function setData(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Get an attribute from the container.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return $this->value($default);
    }

    /**
     * Get the attributes from the container.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $array
     * @return array
     */
    protected function prepareArray(iterable $array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            $v = null;
            if (is_object($value)) {
                if ($value instanceof Arrayable) {
                    $v = $value->toArray();
                }
            } elseif (is_array($value)) {
                $v = $this->prepareArray($value);
            } else {
                $v = $value;
            }

            if (!empty($v)) {
                $result[$key] = $this->value($v);
            }
        }

        return $result;
    }

    /**
     * Convert the Fluent instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->prepareArray($this->data);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the Fluent instance to JSON.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }

    /**
     * Get the value for a given offset.
     *
     * @param  string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    /**
     * Set the value at the given offset.
     *
     * @param  string $offset
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }

    /**
     * Unset the value at the given offset.
     *
     * @param  string $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }

    /**
     * Handle dynamic calls to the container to set attributes.
     *
     * @param  string $method
     * @param  array $parameters
     * @return $this
     */
    public function __call($method, $parameters)
    {
        $this->data[$method] = count($parameters) > 0 ? $parameters[0] : true;

        return $this;
    }

    /**
     * Dynamically retrieve the value of an attribute.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Dynamically set the value of an attribute.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Dynamically check if an attribute is set.
     *
     * @param  string $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Dynamically unset an attribute.
     *
     * @param  string $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->data[$key]);
    }

    /**
     * @param $value
     * @return mixed
     */
    private function value($value)
    {
        return $value instanceof \Closure ? $value() : $value;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator():ArrayIterator
    {
        return new FluentIterator($this->data);
    }
}
