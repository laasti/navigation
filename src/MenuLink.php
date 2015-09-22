<?php

namespace Laasti\Navigation;

/**
 * MenuLink Class
 *
 */
class MenuLink
{
    protected $href;
    protected $label;
    protected $children;
    protected $attributes;
    protected $containerAttributes;
    protected $break;

    public function __construct($href, $label, $children = [], $attributes = [], $containerAttributes = [], $break = false)
    {
        $this->href = $href;
        $this->label = $label;
        $this->children = $children;
        $this->attributes = new Attributes($attributes);
        $this->containerAttributes = new Attributes($containerAttributes);
        $this->break = $break;
    }

    public function getHref()
    {
        return $this->href;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getContainerAttributes()
    {
        return $this->containerAttributes;
    }

    public function getBreak()
    {
        return $this->break;
    }

    public function setHref($href)
    {
        $this->href = $href;
        return $this;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function setContainerAttributes($containerAttributes)
    {
        $this->containerAttributes = $containerAttributes;
        return $this;
    }

    public function setBreak($break)
    {
        $this->break = $break;
        return $this;
    }

    public function __isset($name)
    {
        return method_exists($this, 'get' . ucfirst($name));
    }

    public function __get($name)
    {
        if (method_exists($this, 'get' . ucfirst($name))) {
            return call_user_func([$this, 'get' . ucfirst($name)]);
        }

        return null;
    }

}
