<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/shoppingCart.class.php');
    require_once(__DIR__ . '/../utils/utils.php');

    $db = getDatabaseConnection();
    $session = new Session();
    $userId = $session->getUserId();

    if (!$userId) { ?>
        <h1>Order Summary</h1>
        <p id="subtotal">Subtotal: </p> 
    <?php } else {
        $userId = (int)cleanInput($userId);
        $subTotal = shoppingCart::calculateCartTotal($db, $userId);
        $subTotalFormatted =  number_format($subTotal, 2) . '$'; ?>
        <h1>Order Summary</h1>
        <p id="subtotal">Subtotal: <?= cleanInput($subTotalFormatted) ?></p> 
        <button onclick="window.location.href = 'payment.php'">Checkout</button>  
    <?php 
    } 
?>
