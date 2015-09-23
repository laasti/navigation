<?php

namespace Laasti\Navigation;

interface ActivatorInterface
{
    public function isActive($url);
}
