<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/item.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST['name'];
        $price = intval($_POST['price']);
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $condition = $_POST['condition'];
        $category = $_POST['category'];
        $size = intval($_POST['size']);

        $nextItemId = Item::getNextItemId($db);
        $newItem = new Item($nextItemId, $name, $price, $brand, $model, $condition, $category, "", $size);

        $newItem->insertIntoDatabase($db, $nextItemId, $name, $price, $brand, $model, $condition, $category, "", $size);

        $stmt = $db->prepare('
            INSERT INTO SellerItem (UserId, ItemId)
            VALUES (?, ?)
        ');
        $stmt->execute([$session->getUserId(), $nextItemId]);

        header('Location: ../pages/account.php');
        exit(); 
    }
?>
