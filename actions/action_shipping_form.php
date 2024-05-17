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

        /*
        $buyerName = $buyer->name;
        $buyerEmail = $buyer->email;
        //$itemName = ;
        $itemPrice = htmlspecialchars($item['price']);
        $address = ;
        $city = ;
        $country = ;
        $postalCode = htmlspecialchars($order['PostalCode']);
        */

    } else {
        header('Location: ../pages/account.php');
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shipping Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .label {
            width: 80mm;
            height: 100mm;
            border: 1px solid #000;
            padding: 10px;
            margin: auto;
        }
        @media print {
            .label {
                width: 80mm;
                height: 100mm;
                border: 1px solid #000;
                padding: 10px;
                margin: auto;
            }
            body {
                margin: 0;
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="shipping-form">
        <h1>Shipping Label</h1>

        <p><strong>Address:</strong> <?= $order->address ?></p>
        <p><strong>City:</strong> <?= $order->city ?></p>
        <p><strong>Country:</strong> <?= $order->country ?></p>
        <p><strong>Postal Code:</strong> <?= $order->postalCode ?></p>
        
        <p><strong>Item:</strong> <?= $item->name ?></p>
        <p><strong>Quantity:</strong> <?= $order->quantity ?></p>
        <p><strong>Total price:</strong> <?= ($order->quantity * $item->price) ?>$ </p>

        <button id="printButton" class="no-print"> Print Shipping Form </button>
        <button id="goBackButton" class="no-print"> Go back </button>
    </div>
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });

        document.getElementById('goBackButton').addEventListener('click', function() {
            window.location.href = "../pages/account.php";
        });
    </script>
</body>
</html>
