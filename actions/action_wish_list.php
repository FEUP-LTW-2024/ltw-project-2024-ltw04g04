<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/wishList.class.php');

$session = new Session();
$db = getDatabaseConnection();

$userId = $session->getUserId();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['itemId'])) {
    $itemId = intval($_POST['itemId']);

    $isItemInWishlist = WishList::isItemInWishList($db, $userId, $itemId);

    if ($isItemInWishlist) {
        $removeResult = WishList::removeItemFromList($db, $userId, $itemId);
        $response = array(
            'success' => 'Item removed from wishlist successfully',
            'isInWishlist' => false
        );
        echo json_encode($response);
    } else {
        $addResult = WishList::addItemToList($db, $userId, $itemId);
        $response = array(
            'success' => 'Item added to wishlist successfully',
            'isInWishlist' => true
        );
        echo json_encode($response);
    }
}
?>
