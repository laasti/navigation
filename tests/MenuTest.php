<?php

namespace Laasti\Navigation\Tests;

use Laasti\Navigation\Menu;
use Laasti\Navigation\MenuLink;

class MenuTest extends \PHPUnit_Framework_TestCase
{

    public function testMenu()
    {
        $menu = new Menu(['href' => '/boo', 'label' => 'Boo']);

        $this->assertTrue(count($menu->links()) === 1);
        $this->assertTrue($menu->getByHref('/boo') instanceof MenuLink);
        $this->assertTrue($menu->getByHref('#^/boo$#', true) instanceof MenuLink);
        $this->assertTrue($menu->getByLabel('Boo') instanceof MenuLink);
        $menu->setAttribute('data-test', true);
        $this->assertTrue($menu->getAttribute('data-test'));
        $menu->removeAttribute('data-test');
        $this->assertTrue($menu->getAttribute('data-test') === null);
        $menu->removeByHref('/boo');
        $this->assertTrue(count($menu->links()) === 0);
        $menu->add('/rerer', 'TEst');
        $menu->removeByLabel('TEst');
        $this->assertTrue(count($menu->links()) === 0);
        $menu->add('/rerer', 'TEst');
        $menu->clear();
        $this->assertTrue(count($menu->links()) === 0);
        $menu->add('/rerer', 'TEst');
        $menu->removeByHref('#^/rer#', true);
        $this->assertTrue(count($menu->links()) === 0);
    }

    public function testSubmenu()
    {
        $menu = new Menu([
            [
                'href' => '/boo', 'label' => 'Boo',
                'submenu_items' => [
                    [
                        'href' => '/boo/1',
                        'label' => 'Boo1'
                    ],
                    [
                        'href' => '/boo/1',
                        'label' => 'Boo2'
                    ],
                    [
                        'href' => '/boo/1',
                        'label' => 'Boo3'
                    ],
                    [
                        'href' => '/boo/2',
                        'label' => 'Boo4'
                    ],
                    [
                        'href' => '/boo/1',
                        'label' => 'Boo5'
                    ],
                ]
            ]
        ]);

        $this->assertTrue($menu->getByHref('/boo')->getSubmenu() instanceof Menu);
        $this->assertTrue(count($menu->getByHref('/boo')->getSubmenu()->links()) === 5);
        $this->assertTrue($menu->getByHref('/boo/1') === null);
        $this->assertTrue($menu->getByHref('/boo/1', false, true) instanceof MenuLink);
        $this->assertTrue($menu->getByHref('#^/boo/1#', true, true) instanceof MenuLink);
        $this->assertTrue($menu->getByLabel('Boo5') === null);
        $this->assertTrue($menu->getByLabel('Boo5', true) instanceof MenuLink);
        $menu->removeByLabel('Boo5', true);
        $this->assertTrue(count($menu->getByHref('/boo')->getSubmenu()->links()) === 4);
        $menu->removeByHref('/boo/2', false, true);
        $this->assertTrue(count($menu->getByHref('/boo')->getSubmenu()->links()) === 3);
    }

    public function testActivator()
    {
        $activator = new \Laasti\Navigation\Activator('/boo/8/8');
        $menu = new Menu([
            [
                'href' => '/boo',
                'label' => 'Boo ancestor',
                'submenu_items' => [
                    [
                        'href' => '/boo/8',
                        'label' => 'Boo parent',
                        'submenu_items' => [
                            [
                                'href' => '/boo/8/8',
                                'label' => 'Boo active',
                            ],
                        ]
                    ],
                ]
            ],
        ], $activator);
        
        $this->assertTrue($menu->getByLabel('Boo ancestor')->getAttribute('class') === ' menu-link-ancestor');
        $this->assertTrue($menu->getByLabel('Boo ancestor')->getContainerAttribute('class') === ' menu-item-ancestor');
        $this->assertTrue($menu->getByLabel('Boo parent', true)->getAttribute('class') === ' menu-link-parent');
        $this->assertTrue($menu->getByLabel('Boo parent', true)->getContainerAttribute('class') === ' menu-item-parent');
        $this->assertTrue($menu->getByLabel('Boo active', true)->getAttribute('class') === ' menu-link-active');
        $this->assertTrue($menu->getByLabel('Boo active', true)->getContainerAttribute('class') === ' menu-item-active');

    }


    public function testMerge()
    {
        $activator = new \Laasti\Navigation\Activator('/boo/8/8');
        $menu = new Menu([
            [
                'href' => '/boo',
                'label' => 'Boo ancestor',
                'submenu_items' => [
                    [
                        'href' => '/boo/8',
                        'label' => 'Boo parent',
                        'submenu_items' => [
                            [
                                'href' => '/boo/8/8',
                                'label' => 'Boo active',
                            ],
                        ]
                    ],
                ]
            ],
        ], $activator);

        $menu->merge($menu);

        $this->assertTrue(count($menu->links()) === 2);

    }
}
