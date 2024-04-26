<?php 
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/item.tpl.php');

    $session = new Session();
    $categories = getCategories();
    generateNavigationMenu($session, $categories);

    $itemId = 101; // CHANGEEEEE
    $db = getDatabaseConnection();
    $item = Item::getItemWithId($db, $itemId);
    drawItem($item);
?>