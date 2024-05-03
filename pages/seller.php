<?php 
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/seller.tpl.php'); 

    $session = new Session();
    $db = getDatabaseConnection();

    if (!$session->isLogin()) {
        die(header('Location: /'));
    }

    $userId = isset($_GET['id']) ? (int)$_GET['id'] : $session->getUserId();
    $user = User::getUserWithId($db, $userId);

    $isCurrentUser = $userId === $session->getUserId();

    $categories = getCategories();
    generateNavigationMenu($session, $categories);
    drawUserProfile($user, $isCurrentUser);
?>
