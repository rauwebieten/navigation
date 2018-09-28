<?php

namespace RauweBieten\Navigation;

class NavItem
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $label;

    /** @var string|null */
    protected $url;

    public function __construct(string $id, string $label, ?string $url = null)
    {
        $this->id = $id;
        $this->label = $label;
        $this->url = $url;
    }

    /** @var array|NavItem[] */
    protected $children = [];

    /** @var NavItem|null */
    protected $parent;

    /** @var bool */
    protected $active = false;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @param null|string $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param NavItem $child
     * @return NavItem
     */
    public function addChild(NavItem $child): NavItem
    {
        if ($child->getParent()) {
            throw new \RuntimeException('Child is already under a parent');
        }
        $this->children[] = $child;
        $child->setParent($this);
        return $this;
    }

    /**
     * @param NavItem $child
     * @return bool
     */
    public function hasChild(NavItem $child): bool
    {
        foreach ($this->getChildren() as $_child) {
            if ($_child === $child) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param NavItem $parent
     * @return NavItem
     */
    protected function setParent(NavItem $parent): NavItem
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return array|NavItem[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return null|NavItem
     */
    public function getParent(): ?NavItem
    {
        return $this->parent;
    }

    /**
     * @param bool $includeMe
     * @return array|NavItem[]
     */
    public function getAncestors(bool $includeMe = true): array
    {
        $array = [];
        if ($includeMe === true) {
            $array[] = $this;
        }
        if ($this->getParent() !== null) {
            $array = array_merge($this->getParent()->getAncestors(), $array);
        }
        return $array;
    }

    /**
     * @param bool $includeMe
     * @return array|NavItem[]
     */
    public function getSiblings(bool $includeMe = true): array
    {
        $array = [];
        if ($this->getParent()) {
            foreach ($this->getParent()->getChildren() as $sibling) {
                if ($sibling !== $this || $includeMe === true) {
                    $array[] = $sibling;
                }
            }
        }
        return $array;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return NavItem
     */
    public function setActive(bool $active): NavItem
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasActiveDescendant(): bool
    {
        foreach ($this->getChildren() as $child) {
            if ($child->isActive() or $child->hasActiveDescendant()) {
                return true;
            }
        }
        return false;
    }

    public function findItemById($id): ?NavItem
    {
        return $this->findItemBy(function (NavItem $item) use ($id) {
            return $item->getId() === $id;
        });
    }

    public function findActiveItem(): ?NavItem
    {
        return $this->findItemBy(function (NavItem $item) {
            return $item->isActive();
        });
    }

    /**
     * @param callable $callback
     * @return null|NavItem
     */
    public function findItemBy(callable $callback): ?NavItem
    {
        if ($callback($this) === true) {
            return $this;
        }
        foreach ($this->getChildren() as $child) {
            $found = $child->findItemBy($callback);
            if ($found) {
                return $found;
            }
        }
        return null;
    }
}