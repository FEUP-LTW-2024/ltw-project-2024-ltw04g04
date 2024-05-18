<?php 
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/index.tpl.php');

    $session = new Session();
    $categories = getCategories();
    $pdo = getDatabaseConnection();
    generateNavigationMenu($session, $categories);
    drawWelcomePage();
    topSellers($pdo);
    generateFooter();
?>

