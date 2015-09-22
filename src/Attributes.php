<?php

namespace Laasti\Navigation;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

class Attributes implements IteratorAggregate, ArrayAccess
{

    protected $attributes = [];
    
    public function __construct($attributes = [])
    {
        $this->setAttributes($attributes);
    }

    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
        return $this;
    }

    public function getAttribute($attribute)
    {
        return $this->attributes[$attribute];
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function removeAttribute($attribute)
    {
        if (isset($this->attributes[$attribute])) {
            unset($this->attributes[$attribute]);
        }
        return $this;
    }

    public function __toString()
    {
        $attribute_str = ' ';
        
        foreach ($this->attributes as $attribute => $value) {
            $attribute_str .= $attribute.'="'.  htmlspecialchars((string)$value, ENT_QUOTES).'" ';
        }

        return $attribute_str;
    }

    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    public function offsetUnset($offset)
    {
        $this->removeAttribute($offset);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->attributes);
    }

}
