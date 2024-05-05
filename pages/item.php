<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/item.tpl.php');

$session = new Session();
$categories = getCategories();
generateNavigationMenu($session, $categories);

if (isset($_GET['id'])) {
    $itemId = (int)$_GET['id'];
    $pdo = getDatabaseConnection();
    $user = User::getUserWithId($pdo, $session->getUserId());
    $item = Item::getItemWithId($pdo, $itemId);
    drawItem($pdo,$user->userId, $item);
} else {
    echo "ID do item não fornecido.";
}
?>
