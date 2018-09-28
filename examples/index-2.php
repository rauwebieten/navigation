<?php

use RauweBieten\Navigation\NavItem;use RauweBieten\Navigation\Renderer\Bootstrap4;

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

$found = $root->findItemById('item-2.5');
$found->setActive(true);

$renderer = new Bootstrap4();
$root->accept($renderer);

?><!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <h1>Hello, world!</h1>
    <?php print $renderer->breadcrumb(); ?>
    <hr>
    <?php print $renderer->tabs(); ?>
    <hr>
    <?php print $renderer->pills(); ?>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>