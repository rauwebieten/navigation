<?php

use RauweBieten\Navigation\NavItem;

require_once '../vendor/autoload.php';

$root = new NavItem('root', 'Root');

for ($i = 1; $i <= 5; $i++) {
    $item = new NavItem("item-{$i}", "Item {$i}");
    $root->addChild($item);

    for ($j = 1; $j <= 5; $j++) {
        $subitem = new NavItem("item-{$i}.{$j}", "Item {$i}.{$j}");
        $item->addChild($subitem);

        for ($k = 1; $k <= 5; $k++) {
            $subsubitem = new NavItem("item-{$i}.{$j}.{$k}", "Item {$i}.{$j}.{$k}");
            $subitem->addChild($subsubitem);
        }
    }
}

// TESTING

$found = $root->findItemById('item-2.5.1');
$found->setActive(true);
$found = $root->findActiveItem();

foreach ($found->getAncestors() as $ancestor) {
    print $ancestor->getId().PHP_EOL;
}

print "---------------\n";

foreach ($found->getSiblings() as $sibling) {
    print $sibling->getId(). ' | ';
}
print "\n";
print "---------------\n";

foreach ($found->getParent()->getSiblings() as $sibling) {
    print $sibling->getId(). ' | ';
}
print "\n";
print "---------------\n";
