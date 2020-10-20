<?php

namespace Laasti\Navigation;

/**
 * Breadcrumb Class
 *
 */
class Breadcrumb
{
    /**
     * Array of breadcrumb links
     * @var array 
     */
    protected $links = [];

    /**
     * Constructor
     * @param array $config Initial links
     */
    public function __construct($config = [])
    {
        $this->addFromArray($config);
    }

    /**
     * Add a link to the breadcrumb
     * 
     * @param string $href
     * @param string $label
     * @param array $attributes
     * @return \Laasti\Navigation\Breadcrumb
     */
    public function add($href, $label, $attributes = [])
    {
        $this->links[] = new BreadcrumbItem($href, $label, $attributes);
        
        return $this;
    }

    /**
     * Batch add links to the breadcrumb
     * 
     * @param array $array
     * @return \Laasti\Navigation\Breadcrumb
     */
    public function addFromArray($array)
    {
        $defaults = [
            'label' => null,
            'href' => '#',
            'attributes' => []
        ];
        
        foreach ($array as $config) {
            $config = $config+$defaults;
            $this->add($config['href'], $config['label'], $config['attributes']);
        }
        
        return $this;
    }

    /**
     * Retrieve an item by its href
     * @param string $href
     * @param bool $regex Use preg_match
     * @return BreadcrumbItem
     */
    public function getByHref($href, $regex = false)
    {
        foreach ($this->links as $link) {
            if ($regex && preg_match($href, $link->getHref())) {
                return $link;
            } else if ($link->getHref() === $href) {
                return $link;
            }
        }
        
        return null;
    }

    /**
     * Retrieve an item by its label
     * @param string $label
     * @return BreadcrumbItem
     */
    public function getByLabel($label)
    {        
        foreach ($this->links as $link) {
            if ($link->getLabel() === $label) {
                return $link;
            }
        }
        
        return null;
    }

    /**
     * Remove an item by its href
     * @param string $href
     * @param bool $regex Use preg_match
     * @return Breadcrumb
     */
    public function removeByHref($href, $regex = false)
    {        
        foreach ($this->links as $key => $link) {
            if ($regex && preg_match($href, $link->getHref())) {
                unset($this->links[$key]);
            } else if ($link->getHref() === $href) {
                unset($this->links[$key]);
            }
        }
        
        return $this;
    }

    /**
     * Remove an item by its label
     * @param string $label
     * @return Breadcrumb
     */
    public function removeByLabel($label)
    {
        foreach ($this->links as $key => $link) {
            if ($link->getLabel() === $label) {
                unset($this->links[$key]);
            }
        }
        
        return $this;

    }
    
    /**
     * Removes all links in the breadcrumb
     * @return \Laasti\Navigation\Breadcrumb
     */
    public function clear()
    {
        $this->links = [];
        
        return $this;
    }
    
    /**
     * Returns all breadcrumb links
     * @return array
     */
    public function getLinks()
    {
        if (count($this->links)) {
            $last_link = end($this->links);
            $last_link->setActive(true);
        }
        return $this->links;
    }
    
    /**
     * Alias of getLinks for more readable templates
     * @return array
     */
    public function links()
    {
        return $this->getLinks();
    }
}
