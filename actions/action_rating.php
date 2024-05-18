<?php
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf'], $_POST['seller_id'], $_POST['rating'])) {
    if ($_POST['csrf'] !== $_SESSION['csrf']) {
        die('CSRF token mismatch.');
    }

    $pdo = getDatabaseConnection();
    $sellerId = (int) $_POST['seller_id'];
    $rating = (int) $_POST['rating'];
    $raterId = $session->getUserId();

    if ($rating < 1 || $rating > 5) {
        die('Invalid rating value.');
    }

    $stmt = $pdo->prepare('INSERT INTO SellerRating (SellerId, RaterId, Rating) VALUES (?, ?, ?)');
    if ($stmt->execute([$sellerId, $raterId, $rating])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header('Location: ../pages/error.php');
        exit();
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>

