<?php

namespace Laasti\Navigation;

/**
 * Activator Class
 *
 */
class Activator implements ActivatorInterface
{
    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function isActive($url)
    {
        return $url === $this->url;
    }
}
