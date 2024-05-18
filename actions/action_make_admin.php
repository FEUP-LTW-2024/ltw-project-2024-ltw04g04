<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/utils.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if (!$session->isAdmin() or $_SESSION['csrf'] !== $_POST['csrf']) {
        header('Location: ../pages/error.php');
        exit();
    }

    if (isset($_POST['user_id']) && isset($_POST['action'])) {
        $user_id = cleanInput(intval($_POST['user_id']));
        $action = cleanInput($_POST['action']); 

        if ($action === 'make_admin') {
            User::upgradeUserToAdmin($db, $user_id);
        } elseif ($action === 'remove_admin') {
            User::downgradeUser($db, $user_id);
        }
    }

    $referer = $_SERVER['HTTP_REFERER'] ?? '../pages/index.php';
    header('Location: ' . $referer);
    exit();
?>


