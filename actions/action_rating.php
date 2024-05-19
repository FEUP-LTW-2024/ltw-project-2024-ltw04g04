<?php
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/utils.php');

    $session = new Session();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf'], $_POST['seller_id'], $_POST['rating'])) {
        if ($_POST['csrf'] !== $_SESSION['csrf']) {
            die('CSRF token mismatch.');
        }

        $pdo = getDatabaseConnection();
        $sellerId = cleanInput((int) $_POST['seller_id']);
        $rating = cleanInput((int) $_POST['rating']);
        $raterId = $session->getUserId();

        if ($rating < 1 || $rating > 5) {
            die('Invalid rating value.');
        }

        $stmt = $pdo->prepare('SELECT * FROM SellerRating WHERE SellerId = ? AND RaterId = ?');
        $stmt->execute([$sellerId, $raterId]);
        $existingEntry = $stmt->fetch();

        if ($existingEntry) {
            $stmt = $pdo->prepare('UPDATE SellerRating SET Rating = ? WHERE SellerId = ? AND RaterId = ?');
            if ($stmt->execute([$rating, $sellerId, $raterId])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header('Location: ../pages/error.php');
                exit();
            }
        } else {
            $stmt = $pdo->prepare('INSERT INTO SellerRating (SellerId, RaterId, Rating) VALUES (?, ?, ?)');
            if ($stmt->execute([$sellerId, $raterId, $rating])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                header('Location: ../pages/error.php');
                exit();
            }
        }
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
?>



