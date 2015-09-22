<?php

namespace Laasti\Navigation;

/**
 * BreadcrumbItem Class
 *
 */
class BreadcrumbItem
{
    /**
     * Href
     * @var string
     */
    protected $href;
    
    /**
     * Label
     * @var string 
     */
    protected $label;
    
    /**
     * Attributes
     * @var Attributes 
     */
    protected $attributes;
    
    /**
     * If link is active
     * @var bool 
     */
    protected $active;

    /**
     * Constructor
     * @param string $href
     * @param string $label
     * @param array $attributes
     */
    public function __construct($href, $label, $attributes)
    {
        $this->href = $href;
        $this->label = $label;
        $this->attributes = $attributes;
    }

    /**
     * Get href
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Get label
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get attributes
     * @return Attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    
    /**
     * If link is active
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set if link is active
     * @param bool $active
     * @return \Laasti\Navigation\BreadcrumbItem
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Set href
     * @param string $href
     * @return \Laasti\Navigation\BreadcrumbItem
     */
    public function setHref($href)
    {
        $this->href = $href;
        return $this;
    }

    /**
     * Set label
     * @param string $label
     * @return \Laasti\Navigation\BreadcrumbItem
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Replace attributes
     * @param Attributes $attributes
     * @return \Laasti\Navigation\BreadcrumbItem
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Magic method that check if magic property is accessible
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return method_exists($this, 'get' . ucfirst($name));
    }

    /**
     * Get magic property, all getters are accessible as a read only property
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (method_exists($this, 'get' . ucfirst($name))) {
            return call_user_func([$this, 'get' . ucfirst($name)]);
        }

        return null;
    }

}
