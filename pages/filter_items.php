<?php 
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/index.tpl.php');
    require_once(__DIR__ . '/../templates/filter.tpl.php');

    $session = new Session();
    $categories = getCategories();

    generateNavigationMenu($session, $categories);
    $filteredItems = [];

    if (isset($_GET['filteredItems']) && !empty($_GET['filteredItems'])) {
        $filteredItems = unserialize(urldecode($_GET['filteredItems']));
    }

    drawFilteredItemsPage($filteredItems);
    generateFooter();
?>
