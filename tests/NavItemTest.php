<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use RauweBieten\Navigation\NavItem;

class NavItemTest extends TestCase
{
    public function testAddAndHasChild() :void
    {
        $root = new NavItem('root', 'Root');
        $child = new NavItem('child', 'Child');
        $root->addChild($child);

        $this->assertTrue($root->hasChild($child));
    }
}
