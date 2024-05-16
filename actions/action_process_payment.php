<?php
declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/ShoppingCart.class.php');
require_once(__DIR__ . '/../database/database.sql');

$session = new Session();
$db = getDatabaseConnection();
$userId =  $session->getUserId();

if ($_SESSION['csrf'] === $_GET['csrf']) {
    $address = $_GET['address'] ?? '';
    $city = $_GET['city'] ?? '';
    $country = $_GET['country'] ?? '';
    $postalCode = $_GET['postal-code'] ?? '';

    if ($address === "" || $city === "" || $country === "" || $postalCode === "") {
        $addressInfo = User::getAdressInfo($db, $userId);
        $address = $addressInfo[0];
        $city = $addressInfo[1];
        $country = $addressInfo[2];
        $postalCode = $addressInfo[3];
    }

    $cardNumber = $_GET['card-number'] ?? '';
    $expirationDate = $_GET['expiration-date'] ?? '';
    $cvv = $_GET['cvv'] ?? '';


    $db->beginTransaction();
    

    $paymentSuccess = true;
    if ($paymentSuccess) {
        try {
        
            $db->beginTransaction();

            $stmt = $db->prepare('INSERT INTO Orders (UserId, Adress, City, Country, PostalCode, CardNumber, ExpirationDate, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$userId, $address, $city, $country, $postalCode, $cardNumber, $expirationDate, $cvv]);
            $stmt = $db->query('SELECT MAX(OrderId) FROM Orders');
            $orderId = $stmt->fetchColumn();
            if ($orderId == null)
                $orderId = 0;
            else 
                $orderId = $orderId + 1;
     
            $itemIds = shoppingCart::getItemIdsInCart($db, $userId);
            foreach ($itemIds as $itemId) {
                $item = Item::getItemWithId($db, $itemId);
                $quantity = shoppingCart::getItemQuantityInCart($db, $userId, $itemId);
                $price = $item->price;

                $stmt = $db->prepare('INSERT INTO OrderItem (OrderId, ItemId, Quantity, Price) VALUES (?, ?, ?, ?)');
                $stmt->execute([$orderId, $itemId, $quantity, $price]);

 
                $items = http_build_query([
                    'name' => $item->name,
                    'price' => $price,
                    'id' => $itemId,
                    'csrf' => $_GET['csrf'] // Usando $_GET para acessar os parâmetros
                ]);
                $url = "/../actions/action_shipping_form.php?$items";
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


