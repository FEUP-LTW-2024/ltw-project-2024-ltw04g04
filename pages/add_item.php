<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/item.tpl.php');

    $session = new Session();
    $pdo = getDatabaseConnection();
    $categories = getCategories();
    generateNavigationMenu($session, $categories);

    sellingItem($pdo);
    generateFooter();
?>