<?php

namespace RauweBieten\Navigation\Renderer;

use RauweBieten\Navigation\NavItem;

class Bootstrap4 implements RendererInterface
{
    /** @var NavItem */
    protected $navigation;

    public function visitNavigation(NavItem $navItem)
    {
        $this->navigation = $navItem;
    }

    public function breadcrumb(): string
    {
        $active = $this->navigation->findActiveItem();
        $html = '';
        if ($active) {
            $html .= '<ol class="breadcrumb">';
            $ancestors = $active->getAncestors();
            foreach ($ancestors as $ancestor) {

                if ($ancestor->isActive()) {
                    $html .= '<li class="breadcrumb-item active">' . $ancestor->getLabel() . '</li>';
                } else {
                    $link = '<a href="' . ($ancestor->getUrl() ?: '') . '">' . $ancestor->getLabel() . '</a>';
                    $html .= '<li class="breadcrumb-item active">' . $link . '</li>';
                }

            }
            $html .= '</ol>';
        }
        return $html;
    }

    public function tabs() :string
    {
        return $this->nav('nav-tabs');
    }

    public function pills() :string
    {
        return $this->nav('nav-pills');
    }

    public function nav($type): string
    {
        $active = $this->navigation->findActiveItem();
        $html = '';
        if ($active) {
            $html .= '<ul class="nav '.$type.'">';
            foreach ($active->getSiblings() as $sibling) {

                if ($sibling->isActive()) {
                    $link = '<a class="nav-link active" href="' . ($sibling->getUrl() ?: '') . '">' . $sibling->getLabel() . '</a>';
                    $html .= '<li class="nav-item">' . $link . '</li>';
                } else {
                    $link = '<a class="nav-link" href="' . ($sibling->getUrl() ?: '') . '">' . $sibling->getLabel() . '</a>';
                    $html .= '<li class="nav-item">' . $link . '</li>';
                }

            }
            $html .= '</ul>';
        }
        return $html;
    }
}