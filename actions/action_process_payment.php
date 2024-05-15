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

    $paymentSuccess = true;

    if ($paymentSuccess) {
        try {
        
            $db->beginTransaction();

            $stmt = $db->prepare('INSERT INTO Order (UserId, Adress, City, Country, PostalCode, CardNumber, ExpirationDate, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$userId, $address, $city, $country, $postalCode, $cardNumber, $expirationDate, $cvv]);
            $orderId = $db->lastInsertId();

     
            $itemIds = shoppingCart::getItemIdsInCart($db, $userId);
            foreach ($itemIds as $itemId) {
                $item = Item::getItemWithId($db, $itemId);
                $quantity = shoppingCart::getItemQuantityInCart($db, $userId, $itemId);
                $price = $item->price;

                $stmt = $db->prepare('INSERT INTO OrderItem (OrderId, ItemId, Quantity, Price) VALUES (?, ?, ?, ?)');
                $stmt->execute([$orderId, $itemId, $quantity, $price]);

 
                $params = http_build_query([
                    'name' => $item->name,
                    'price' => $price,
                    'id' => $itemId,
                    'csrf' => $_POST['csrf']
                ]);
                $url = "../actions/action_shipping_form.php?$params";
                echo "<script>window.open('$url', '_blank');</script>";

            
                shoppingCart::removeItemFromCart($db, $userId, $itemId);
            }

            $db->commit();
            echo 'success';
        } catch (Exception $e) {
            $db->rollBack();
            echo "Failed to process order: " . $e->getMessage();
        }
    } else {
        echo "Payment processing failed.";
    }
} else {
    echo "Invalid CSRF token.";
}
?>


