<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/wishList.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if (isset($_POST['itemId']) and isset($_POST['action'])) {
    
        $itemId = $_POST['itemId'];
        $action = $_POST['action'];
        $pdo = getDatabaseConnection();
        
        $result = WishList::manageWishListItem($pdo, $session->getUserId(), $itemId, $action);
        header('Location: ../pages/item.php');
        exit();    
    } 

?>