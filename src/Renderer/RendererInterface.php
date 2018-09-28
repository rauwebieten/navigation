<?php

namespace RauweBieten\Navigation\Renderer;

use RauweBieten\Navigation\NavItem;

interface RendererInterface
{
    public function visitNavigation(NavItem $navItem);
}