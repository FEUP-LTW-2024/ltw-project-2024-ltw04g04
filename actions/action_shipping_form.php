<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/order.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if (isset($_POST['orderId'])) {
        $orderId = filter_input(INPUT_POST, 'orderId', FILTER_VALIDATE_INT);

        $order = Order::getOrderwithId($db, $orderId);
        $item = Item::getItemWithId($db, $order->itemId);
        $buyer = User::getUserWithId($db, $order->buyerId);

    } else {
        header('Location: ../pages/account.php');
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shipping Form</title>
    <link rel="stylesheet" type="text/css" href="../css/style-shipform.css">
    <script defer src="../javascript/shipform.js"></script>
    
</head>
<body>
    <div class="shipping-form">
        <h1>Shipping Form</h1>
        
        <div class="ship-div">
            <h3> Customer </h3>
            <p class="shipping"><strong>Name:</strong> <?= $buyer->name ?></p>
            <p class="shipping"><strong>Email:</strong> <?= $buyer->email ?></p>
        </div>

        <div class="ship-div">
            <h3> Delivery Information </h3>
            <p class="shipping"><strong>Address:</strong> <?= $order->address ?></p>
            <p class="shipping"><strong>City:</strong> <?= $order->city ?></p>
            <p class="shipping"><strong>Country:</strong> <?= $order->country ?></p>
            <p class="shipping"><strong>Postal Code:</strong> <?= $order->postalCode ?></p>
        </div>
        
        <h3> Purchase Details </h3>
        <p class="shipping"><strong>Item:</strong> <?= $item->name ?></p>
        <p class="shipping"><strong>Quantity:</strong> <?= $order->quantity ?></p>
        <p class="shipping"><strong>Total price:</strong> <?= ($order->quantity * $item->price) ?>$ </p>

    </div>

    <button id="printButton" class="no-print"> Print Shipping Form </button>
    <button id="goBackButton" class="no-print"> Go back </button>
    
</body>
</html>
