<?php

namespace Laasti\Navigation;

class Menu
{

    protected $links = [];
    protected $attributes;
    protected $activator;
    protected $parent;
    protected $defaults = [
        'href' => '#',
        'label' => '',
        'submenu_items' => [],
        'attributes' => [],
        'container_attributes' => [],
        'break' => false
    ];
    protected $classes = [
        'active' => 'menu-link-active',
        'parent' => 'menu-link-parent',
        'ancestor' => 'menu-link-ancestor',
        'container_active' => 'menu-item-active',
        'container_parent' => 'menu-item-parent',
        'container_ancestor' => 'menu-item-ancestor',
    ];

    public function __construct($config = [], ActivatorInterface $activator = null, $attributes = [])
    {
        $this->activator = $activator;
        $this->attributes = new Attributes($attributes);
        $this->addFromArray($config);
    }

    public function addFromArray($config)
    {
        //Compare keys from defaults to keys from config to check if its a single item
        //Or an array of items
        if (count($config) && !count(array_diff(array_keys($config), array_keys($this->defaults)))) {
            //Convert to array of items
            $config = [$config];
        }

        foreach ($config as $itemconfig) {
            $values = $itemconfig + $this->defaults;
            $this->add($values['href'], $values['label'], $values['submenu_items'], $values['attributes'],
                $values['container_attributes'], $values['break']);
        }

        return $this;
    }

    public function add($href, $label, $submenuItems = [], $attributes = [], $containerAttributes = [], $break = false)
    {
        $link = new MenuLink($href, $label, null, $attributes, $containerAttributes, $break);
        $link->setParent($this);
        if (count($submenuItems)) {
            $submenu = new Menu([], $this->getActivator());
            $submenu->setParent($link);
            $link->setSubmenu($submenu);
            $submenu->addFromArray($submenuItems);
        }
        $this->links[] = $link;
        if (!is_null($this->getActivator()) && $this->getActivator()->isActive($href)) {
            $this->activate($link);
        }

        return $this;
    }

    /**
     * Get current activator
     * @return ActivatorInterface
     */
    public function getActivator()
    {
        return $this->activator;
    }

    /**
     * Set activator
     * @param \Laasti\Navigation\ActivatorInterface $activator
     * @return \Laasti\Navigation\Menu
     */
    public function setActivator(ActivatorInterface $activator)
    {
        $this->activator = $activator;
        return $this;
    }

    /**
     * Add classes to the current link and its ancestors
     * @param \Laasti\Navigation\MenuLink $link
     */
    protected function activate(MenuLink $link)
    {
        $link->setAttribute('class', $link->getAttribute('class') . ' ' . $this->classes['active']);
        $link->setContainerAttribute('class',
            $link->getContainerAttribute('class') . ' ' . $this->classes['container_active']);
        $parent = $link->getParent();
        $level = 0;
        while ($parent instanceof Menu || $parent instanceof MenuLink) {
            if ($parent instanceof Menu) {
                $parent = $parent->getParent();
                continue;
            }

            if (!$level) {
                $parent->setAttribute('class', $parent->getAttribute('class') . ' ' . $this->classes['parent']);
                $parent->setContainerAttribute('class',
                    $parent->getContainerAttribute('class') . ' ' . $this->classes['container_parent']);
            } else {
                $parent->setAttribute('class', $parent->getAttribute('class') . ' ' . $this->classes['ancestor']);
                $parent->setContainerAttribute('class',
                    $parent->getContainerAttribute('class') . ' ' . $this->classes['container_ancestor']);
            }
            $level++;
            $parent = $parent->getParent();
        }
    }

    /**
     * Get an item by its href
     *
     * @param string $href
     * @param bool $regex
     * @param bool $deep Get from submenus too
     * @param array $links Used for recursion
     * @return \Laasti\Navigation\MenuLink
     */
    public function getByHref($href, $regex = false, $deep = false, $links = null)
    {

        $links = $links ?: $this->getLinks();
        foreach ($links as $link) {
            if ($regex && preg_match($href, $link->getHref())) {
                return $link;
            } elseif ($link->getHref() === $href) {
                return $link;
            }

            if ($deep && !is_null($link->getSubmenu()) && count($link->getSubmenu()->getLinks())) {
                $result = $this->getByHref($href, $regex, $deep, $link->getSubmenu()->getLinks());
                if (!is_null($result)) {
                    return $result;
                }
            }
        }

        return null;
    }

    /**
     * Returns all menu links
     * @return array
     */
    public function &getLinks()
    {
        return $this->links;
    }

    /**
     * Get an item by its label
     *
     * @param string $label
     * @param bool $deep Get from submenus too
     * @param array $links Used for recursion
     * @return \Laasti\Navigation\MenuLink
     */
    public function getByLabel($label, $deep = false, $links = null)
    {
        $links = $links ?: $this->getLinks();
        foreach ($links as $link) {
            if ($link->getLabel() === $label) {
                return $link;
            }

            if ($deep && !is_null($link->getSubmenu()) && count($link->getSubmenu()->getLinks())) {
                $result = $this->getByLabel($label, $deep, $link->getSubmenu()->getLinks());
                if (!is_null($result)) {
                    return $result;
                }
            }
        }

        return null;
    }

    /**
     * Get attribute from attributes object
     * @return string
     */
    public function getAttribute($attribute)
    {
        return $this->attributes->getAttribute($attribute);
    }

    /**
     * Set attribute in attributes object
     * @return string
     */
    public function setAttribute($attribute, $value)
    {
        return $this->attributes->setAttribute($attribute, $value);
    }

    /**
     * Remove attribute in attributes object
     * @return string
     */
    public function removeAttribute($attribute)
    {
        return $this->attributes->removeAttribute($attribute);
    }

    /**
     * Remove an item by its href
     *
     * @param string $href
     * @param bool $regex
     * @param bool $deep Remove from submenus too
     * @param array $links Used for recursion
     * @return \Laasti\Navigation\Menu
     */
    public function removeByHref($href, $regex = false, $deep = false, $menu = null)
    {
        if (is_null($menu)) {
            $menu = $this;
        }
        $links = &$menu->getLinks();
        foreach ($links as $key => $link) {
            if ($regex && preg_match($href, $link->getHref())) {
                unset($links[$key]);
                continue;
            } elseif ($link->getHref() === $href) {
                unset($links[$key]);
                continue;
            }

            if ($deep && !is_null($link->getSubmenu()) && count($link->getSubmenu()->getLinks())) {
                $this->removeByHref($href, $regex, $deep, $link->getSubmenu());
            }
        }

        return $this;
    }

    /**
     * Remove an item by its label
     *
     * @param string $label
     * @param bool $deep Remove from submenus too
     * @param array $links Used for recursion
     * @return \Laasti\Navigation\Menu
     */
    public function removeByLabel($label, $deep = false, $menu = null)
    {
        if (is_null($menu)) {
            $menu = $this;
        }
        $links = &$menu->getLinks();
        foreach ($links as $key => $link) {
            if ($link->getLabel() === $label) {
                unset($links[$key]);
                continue;
            }

            if ($deep && !is_null($link->getSubmenu()) && count($link->getSubmenu()->getLinks())) {
                $this->removeByLabel($label, $deep, $link->getSubmenu());
            }
        }

        return $this;
    }

    /**
     * Removes all links in the menu
     * @return \Laasti\Navigation\Menu
     */
    public function clear()
    {
        $this->links = [];
        return $this;
    }

    /**
     * Get parent (used internally to be able to use recursion)
     * @return MenuLink
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent (used internally to be able to use recursion)
     * @param \Laasti\Navigation\MenuLink $parent
     * @return \Laasti\Navigation\Menu
     */
    public function setParent(MenuLink $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Set classes to add when link is active
     * * Must be called before links are added to the menu
     * @param string $active Active link
     * @param string $parent Direct parent
     * @param string $ancestor Parent
     * @param string $container_active Active link
     * @param string $container_parent Direct parent
     * @param string $container_ancestor Parent
     * @return \Laasti\Navigation\Menu
     */
    public function setClasses($active, $parent, $ancestor, $container_active, $container_parent, $container_ancestor)
    {
        $this->classes = [
            'active' => $active,
            'parent' => $parent,
            'ancestor' => $ancestor,
            'container_active' => $container_active,
            'container_parent' => $container_parent,
            'container_ancestor' => $container_ancestor,
        ];
        return $this;
    }

    public function merge(Menu $menu)
    {
        foreach ($menu->links() as $link) {
            $this->addLink($link);
        }

        return $this;
    }

    /**
     * Alias of getLinks for more readable templates
     * @return array
     */
    public function &links()
    {
        return $this->getLinks();
    }

    public function addLink(MenuLink $link)
    {
        $this->links[] = $link;

        return $this;
    }
}
