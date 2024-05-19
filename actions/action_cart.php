<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/shoppingCart.class.php');
    require_once(__DIR__ . '/../utils/utils.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if (!$session->isLogin()) {
        header('Location: ../pages/login.php');
        exit();
    }


    if (isset($_POST['itemId']) && isset($_POST['action'])) {
        $itemId = intval(cleanInput($_POST['itemId'])); 
        $action = cleanInput($_POST['action']);
        
        if ($action === 'add' || $action === 'remove' || $action === 'decrease' || $action == 'total') {
            $result = shoppingCart::manageCartItem($db, $session->getUserId(), $itemId, $action);
            if ($result) {
                header('Location: ../pages/cart.php');
                exit();
            } else {
                header('Location: ../pages/error.php');
                exit();
            }
        } else {
            header('Location: ../pages/error.php');
            exit();
        }
    } else {
        header('Location: ../pages/error.php');
        exit();
    }
?>

