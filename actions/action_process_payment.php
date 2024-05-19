<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/order.class.php');
    require_once(__DIR__ . '/../database/ShoppingCart.class.php');
    require_once(__DIR__ . '/../utils/utils.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $userId = $session->getUserId();

    if ($_SESSION['csrf'] === $_POST['csrf']) {
        $address = cleanInput($_POST['address']);
        $city = cleanInput($_POST['city']);
        $country = cleanInput($_POST['country']);
        $postalCode = cleanInput($_POST['postal-code']);
        $cardNumber = cleanInput($_POST['card-number']);
        $expirationDate = cleanInput($_POST['expiration-date']);
        $cvv = cleanInput($_POST['cvv']);

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

    header('Location: ../pages/cart.php');
    exit();
?>

