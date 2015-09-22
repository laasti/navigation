<?php

namespace Laasti\Navigation;

/**
 * BreadcrumbItem Class
 *
 */
class BreadcrumbItem
{
    protected $href;
    protected $label;
    protected $attributes;

    public function __construct($href, $label, $attributes)
    {
        $this->href = $href;
        $this->label = $label;
        $this->attributes = $attributes;
    }

    public function getHref()
    {
        return $this->href;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getAttributes()
    {
        return $this->attributes;
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

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
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
