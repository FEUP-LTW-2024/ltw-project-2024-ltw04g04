<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
   
    $session = new Session();
    if (($_SESSION['csrf'] === $_POST['csrf'])) {
        $_SESSION['item-id'] = $_POST['item-id'];
    }

    header("Location: ../pages/item.php");
    exit(); 
?>