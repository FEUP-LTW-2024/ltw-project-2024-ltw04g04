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
        $address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8') ?? "";
        $city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8') ?? "";
        $country = htmlspecialchars($_POST['country'], ENT_QUOTES, 'UTF-8') ?? "";
        $postalCode = htmlspecialchars($_POST['postal-code'], ENT_QUOTES, 'UTF-8') ?? "";

        if ($address === "" || $city === "" || $country === "" || $postalCode === "") {
            $addressInfo = User::getAddressInfo($db, $userId);
            $address = $addressInfo[0];
            $city = $addressInfo[1];
            $country = $addressInfo[2];
            $postalCode = $addressInfo[3];
        }

        $cardNumber = htmlspecialchars($_POST['card-number'], ENT_QUOTES, 'UTF-8');
        $expirationDate = htmlspecialchars($_POST['expiration-date'], ENT_QUOTES, 'UTF-8');
        $cvv = htmlspecialchars($_POST['cvv'], ENT_QUOTES, 'UTF-8');


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
