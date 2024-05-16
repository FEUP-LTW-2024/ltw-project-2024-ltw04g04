<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    $itemName = $_GET['name'] ?? '';
    $itemPrice = $_GET['price'] ?? '';
    $itemId = $_GET['id'] ?? '';

    $address = '';
    $city = '';
    $country = '';
    $postalCode = '';

    if ($session->isLogin()) {
        $addressInfo = User::getAddressInfo($db, $session->getUserId());
        $address = $addressInfo['address'];
        $city = $addressInfo['city'];
        $country = $addressInfo['country'];
        $postalCode = $addressInfo['postal_code'];
    }

    echo "<html>
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
            <p><strong>Item:</strong> $itemName</p>
            <p><strong>Price:</strong> $itemPrice</p>
            <p><strong>Address:</strong> $address</p>
            <p><strong>City:</strong> $city</p>
            <p><strong>Country:</strong> $country</p>
            <p><strong>Postal Code:</strong> $postalCode</p>
        </div>
        <script>
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        </script>
    </body>
    </html>";
?>

