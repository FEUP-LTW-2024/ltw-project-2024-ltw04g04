<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/user.class.php');

if (!isset($_GET['order_id']) || !isset($_GET['item_id'])) {
    die('Order ID and Item ID required');
}

$orderId = (int)$_GET['order_id'];
$itemId = (int)$_GET['item_id'];

$orderStmt = $pdo->prepare('SELECT * FROM OrderItem WHERE OrderId = ?');
$orderStmt->execute([$orderId]);
$order = $orderStmt->fetch();

if (!$order) {
    die('Order not found');
}

$itemStmt = $pdo->prepare('SELECT * FROM Item WHERE ItemId = ?');
$itemStmt->execute([$itemId]);
$item = $itemStmt->fetch();

if (!$item) {
    die('Item not found');
}

$itemName = htmlspecialchars($item['name']);
$itemPrice = htmlspecialchars($item['price']);
$address = htmlspecialchars($order['Address']);
$city = htmlspecialchars($order['City']);
$country = htmlspecialchars($order['Country']);
$postalCode = htmlspecialchars($order['PostalCode']);
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
        }
    </style>
</head>
<body>
    <div class='label'>
        <h2>Shipping Label</h2>
        <p><strong>Item:</strong> <?= $itemName ?></p>
        <p><strong>Price:</strong> <?= $itemPrice ?></p>
        <p><strong>Address:</strong> <?= $address ?></p>
        <p><strong>City:</strong> <?= $city ?></p>
        <p><strong>Country:</strong> <?= $country ?></p>
        <p><strong>Postal Code:</strong> <?= $postalCode ?></p>
    </div>
    <script>
        window.print();
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>
</html>
