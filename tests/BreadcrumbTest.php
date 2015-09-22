<?php

namespace Laasti\Navigation\Tests;

class BreadcrumbTest extends \PHPUnit_Framework_TestCase
{
    public function testBreadcrumb()
    {
        $breadcrumb = new \Laasti\Navigation\Breadcrumb([
            [
                'href' => '#',
                'label' => 'Home'
            ],
            [
                'href' => '/about',
                'label' => 'About'
            ],
            [
                'href' => '/about/the-team',
                'label' => 'The team'
            ],
            [
                'href' => '/about/the-team/peter',
                'label' => 'Peter'
            ]
        ]);
        
        $last = $breadcrumb->links();
        $this->assertTrue(end($last)->active);
        $this->assertTrue($breadcrumb->getByLabel('Home')->getHref() === '#');
        $this->assertTrue($breadcrumb->getByHref('#')->getLabel() === 'Home');
        $this->assertTrue($breadcrumb->getByHref('#^/about/#', true)->getLabel() === 'The team');
        $this->assertTrue($breadcrumb->getByHref('/^\/ab/', true)->getLabel() === 'About');
        $this->assertTrue($breadcrumb->getByHref('/adsa?7&"bout/', true) === null);
        $this->assertTrue($breadcrumb->getByLabel('/adsa?7&"bout/') === null);
        
        $breadcrumb->removeByLabel('Peter');
        $breadcrumb->removeByHref('/about/the-team');
        $breadcrumb->removeByHref('#^/about#', true);
        $this->assertTrue(count($breadcrumb->links()) === 1);
        $breadcrumb->clear();
        $this->assertTrue(count($breadcrumb->links()) === 0);
        
    }
}
