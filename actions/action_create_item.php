<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/item.class.php');

$session = new Session();
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $price = intval($_POST['price']);
    $brand = htmlspecialchars($_POST['brand'], ENT_QUOTES, 'UTF-8');
    $model = htmlspecialchars($_POST['model'], ENT_QUOTES, 'UTF-8');
    $condition = htmlspecialchars($_POST['condition'], ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8');
    $stock = intval($_POST['stock']);
    $size = intval($_POST['size']);

    $nextItemId = Item::getNextItemId($db);
    $newItem = new Item($nextItemId, $name, $price, $brand, $model, $condition, $category, $stock, "", $size);
    echo "$stock";
    $success = $newItem->insertItemInDatabase($db, $nextItemId, $name, $price, $brand, $model, $condition, $category, $stock, "", $size);

    
    $stmt = $db->prepare('
        INSERT INTO SellerItem (UserId, ItemId)
        VALUES (?, ?)
    ');
    $stmt->execute([$session->getUserId(), $nextItemId]);

    header('Location: ../pages/account.php');
    exit();
    
} else {
    header('Location: ../pages/error.php');
    exit();
}
?>

