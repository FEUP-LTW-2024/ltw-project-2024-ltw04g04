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
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        .shipping-form {
            max-width: auto;
            margin: 0;
            padding: 1em 2em 1.5em 2em;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .shipping-form h1 {
            text-align: center;
            margin-bottom: 1em;
        }

        .ship-div {
            border-bottom: 1px solid #ccc;
            padding-bottom: 1.3em;
        }

        .ship-div h3 {
            margin-bottom: 10px;
        }

        .shipping {
            margin-bottom: 0.6em;
        }

        #printButton, #goBackButton {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #00B4D8;
            color: #fff;
            text-align: center;
            cursor: pointer;
        }

        #printButton:hover, #goBackButton:hover {
            background-color: #0077B6;
        }

        .no-print {
            display: none;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
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
