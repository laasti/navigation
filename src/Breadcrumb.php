<?php

namespace Laasti\Navigation;

/**
 * Breadcrumb Class
 *
 */
class Breadcrumb
{
    protected $links;

    public function __construct($config = [])
    {
        $this->addFromArray($config);
    }

    public function add($href, $label, $attributes = [])
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
