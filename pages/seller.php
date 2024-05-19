<?php 
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/seller.tpl.php'); 

    $session = new Session();
    $pdo = getDatabaseConnection();

    $userId = isset($_SESSION['seller-id']) ? (int)$_SESSION['seller-id'] : $session->getUserId();
    $user = User::getUserWithId($pdo, $userId);
    

    $isCurrentUser = $userId === $session->getUserId();

    $categories = getCategories();
    generateNavigationMenu($session, $categories);
    drawSellerProfile($session, $pdo, $user, $isCurrentUser);
    generateFooter();
?>
