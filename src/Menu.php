<?php

namespace Laasti\Navigation;

class Menu
{
    protected $links;
    protected $levels;
    protected $attributes;

    public function __construct($config = [], $levels = null, $attributes = [])
    {
        $this->addFromArray($config);
        $this->levels = $levels;
        $this->attributes = new Attributes($attributes);
    }

    public function add()
    {

    }

    public function addFromArray()
    {

    }

    public function getByHref()
    {

    }

    public function getByLabel()
    {

    }

    public function removeByHref()
    {

    }

    public function removeByLabel()
    {

    }

    public function clear()
    {

    }
}
