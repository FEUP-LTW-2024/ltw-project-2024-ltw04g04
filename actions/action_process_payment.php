<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../database/user.class.php');

$session = new Session();
$db = getDatabaseConnection();

if ($_SESSION['csrf'] === $_GET['csrf']) {
    $address = $_GET['address'] ?? '';
    $city = $_GET['city'] ?? '';
    $country = $_GET['country'] ?? '';
    $postalCode = $_GET['postal-code'] ?? '';

    if (empty($address) || empty($city) || empty($country) || empty($postalCode)) {
        $addressInfo = User::getAddressInfo($db, $session->getUserId());
        $address = $addressInfo['address'];
        $city = $addressInfo['city'];
        $country = $addressInfo['country'];
        $postalCode = $addressInfo['postal_code'];
    }

    $cardNumber = $_GET['card-number'] ?? '';
    $expirationDate = $_GET['expiration-date'] ?? '';
    $cvv = $_GET['cvv'] ?? '';

    echo "<html>
    <head>
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
                transform: translate(0, 0);
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
} else {
    echo "Invalid CSRF token.";
}
?>


