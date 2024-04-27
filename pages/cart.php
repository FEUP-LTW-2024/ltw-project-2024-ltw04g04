<!DOCTYPE html>
<html>
<?php 
    
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/account.tpl.php');

    $session = new Session();
    $pdo = getDatabaseConnection();
    $categories = getCategories();
    generateNavigationMenu($session, $categories);
    drawShoppingCart($pdo, $session);
?>

