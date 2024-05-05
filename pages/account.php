<?php 
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/account.tpl.php');

    $session = new Session();

    if (!$session->isLogin()) die(header('Location: /'));

    $pdo = getDatabaseConnection();
    $user = User::getUserWithId($pdo, $session->getUserId());
    $editMode = isset($_GET['edit']);

    $categories = getCategories();
    generateNavigationMenu($session,$categories);
    drawUserPage($pdo, $user, $editMode);
?>
