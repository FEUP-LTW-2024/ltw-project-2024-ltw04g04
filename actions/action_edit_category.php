<?php
declare(strict_types = 1);
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $user = User::getUserWithId($db, $session->getUserId());

    if (!$user || !$user->isAdmin) {
        header('Location: ../pages/error.php');
        exit();
    }

    if (isset($_POST['add_category'])) {
        $new_category_name = $_POST['new_category_name'];
        
        $stmt = $db->prepare('INSERT INTO Category (CategoryName) VALUES (?)');
        $stmt->execute([$new_category_name]);
        
        header('Location: ./admin_categories.php');
        exit();
    }

    if (isset($_POST['delete_category'])) {
        $category_id_to_delete = $_POST['category_id_to_delete'];
        
        $stmt = $db->prepare('SELECT COUNT(*) FROM Item WHERE Category = ?');
        $stmt->execute([$category_id_to_delete]);
        $item_count = (int) $stmt->fetchColumn();
        
        if ($item_count === 0) {
            $stmt = $db->prepare('DELETE FROM Category WHERE CategoryId = ?');
            $stmt->execute([$category_id_to_delete]);
        } else {

            $error_message = "It is not possible to eliminate this category since it has items associated.";
        }
    }

    $stmt = $db->query('SELECT * FROM Category');
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>