<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/order.class.php');
    require_once(__DIR__ . '/../database/ShoppingCart.class.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $userId = $session->getUserId();

    if ($_SESSION['csrf'] === $_POST['csrf']) {
        $address = $_POST['address'] ?? '';
        $city = $_POST['city'] ?? '';
        $country = $_POST['country'] ?? '';
        $postalCode = $_POST['postal-code'] ?? '';

        if ($address === "" || $city === "" || $country === "" || $postalCode === "") {
            $addressInfo = User::getAddressInfo($db, $userId);
            $address = $addressInfo[0];
            $city = $addressInfo[1];
            $country = $addressInfo[2];
            $postalCode = $addressInfo[3];
        }

        $cardNumber = $_POST['card-number'] ?? '';
        $expirationDate = $_POST['expiration-date'] ?? '';
        $cvv = $_POST['cvv'] ?? '';


        $db->beginTransaction();

        try {
            $itemIds = shoppingCart::getItemIdsInCart($db, $userId);
            foreach ($itemIds as $itemId) {
                $quantity = shoppingCart::getItemQuantityInCart($db, $userId, $itemId);

                shoppingCart::removeItemFromCart($db, $userId, $itemId);
                item::updateStock($db, $itemId, $quantity);

                Order::addOrder($db, $itemId, $quantity, $userId, $address, $city, $country, $postalCode, $cardNumber, $expirationDate, $cvv);
            }

            $db->commit();
            echo 'success';

        } catch (Exception $e) {
            $db->rollBack();
            echo "Failed to process order: " . $e->getMessage();
        }
        
    } else {
        echo "Invalid CSRF token.";
    }

?>
