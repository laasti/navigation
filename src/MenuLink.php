<?php

namespace Laasti\Navigation;

/**
 * MenuLink Class
 *
 */
class MenuLink
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
     * Submenu
     * @var Menu
     */
    protected $submenu;

    /**
     * Attributes
     * @var Attributes
     */
    protected $attributes;

    /**
     * Container attributes
     * @var Attributes
     */
    protected $containerAttributes;

    /**
     * Break to new container
     * @var bool
     */
    protected $break;

    /**
     * Parent
     * @var Menu
     */
    protected $parent;

    /**
     * Constructor
     * @param string $href
     * @param string $label
     * @param \Laasti\Navigation\Menu $submenu
     * @param array $attributes
     * @param array $containerAttributes
     * @param bool $break
     */
    public function __construct(
        $href,
        $label,
        Menu $submenu = null,
        $attributes = [],
        $containerAttributes = [],
        $break = false
    ) {
        $this->href = $href;
        $this->label = $label;
        $this->submenu = $submenu;
        $this->attributes = new Attributes($attributes);
        $this->containerAttributes = new Attributes($containerAttributes);
        $this->break = $break;
    }

    /**
     * Get submenu
     * @return Menu
     */
    public function getSubmenu()
    {
        return $this->submenu;
    }

    /**
     * Set submenu
     * @param Menu $submenu
     * @return \Laasti\Navigation\MenuLink
     */
    public function setSubmenu(Menu $submenu)
    {
        $this->submenu = $submenu;
        return $this;
    }

    /**
     * Get parent (used internally to be able to use recursion)
     * @return Menu
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent (used internally to be able to use recursion)
     * @param Menu $parent
     * @return \Laasti\Navigation\MenuLink
     */
    public function setParent(Menu $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get attribute
     * @param string $attribute
     * @return string
     */
    public function getAttribute($attribute)
    {
        return $this->attributes->getAttribute($attribute);
    }

    /**
     * Get container attributes object
     * @return Attributes
     */
    public function getContainerAttributes()
    {
        return $this->containerAttributes;
    }

    /**
     * Get container attribute
     * @param string $containerAttribute
     * @return string
     */
    public function getContainerAttribute($containerAttribute)
    {
        return $this->containerAttributes->getAttribute($containerAttribute);
    }

    /**
     * Get if break
     * @return bool
     */
    public function getBreak()
    {
        return $this->break;
    }

    /**
     * Set if break
     * @param bool $break
     * @return \Laasti\Navigation\MenuLink
     */
    public function setBreak($break)
    {
        $this->break = $break;
        return $this;
    }

    /**
     * Set attribute
     * @param string $attribute
     * @param string $value
     * @return \Laasti\Navigation\MenuLink
     */
    public function setAttribute($attribute, $value)
    {
        $this->attributes->setAttribute($attribute, $value);
        return $this;
    }

    /**
     * Set container attribute
     * @param string $containerAttribute
     * @param string $value
     * @return \Laasti\Navigation\MenuLink
     */
    public function setContainerAttribute($containerAttribute, $value)
    {
        $this->containerAttributes->setAttribute($containerAttribute, $value);
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

    public function __toString()
    {
        return '<a href="' . $this->getHref() . '" ' . $this->getAttributes() . '>' . $this->getLabel() . '</a>';
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
     * Set href
     * @param string $href
     * @return \Laasti\Navigation\MenuLink
     */
    public function setHref($href)
    {
        $this->href = $href;
        return $this;
    }

    /**
     * Get attributes object
     * @return Attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get Label
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set Label
     * @param string $label
     * @return \Laasti\Navigation\MenuLink
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
}
