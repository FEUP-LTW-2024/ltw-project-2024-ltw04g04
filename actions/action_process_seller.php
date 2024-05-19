<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
   
    $session = new Session();
    if (($_SESSION['csrf'] === $_POST['csrf'])) {
        $_SESSION['seller-id'] = $_POST['seller-id'];
    }

    if ($_SESSION['seller-id'] == $session->getUserId()) {
        header("Location: ../pages/account.php");
        exit();    
    } else {
        header("Location: ../pages/seller.php");
        exit(); 
    }
?>