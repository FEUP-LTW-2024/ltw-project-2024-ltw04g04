<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

if (($_SESSION['csrf'] === $_POST['csrf'])) {
    $db = getDatabaseConnection();
    $user = User::getUserWithId($db, $session->getUserId());

    if (!$user || !$user->isAdmin) {
        header('Location: ../pages/error.php');
        exit();
    }

    if (isset($_POST['add_size'])) {
        $new_size_name = $_POST['new_size_name'];
        
        $stmt = $db->prepare('INSERT INTO Size_(SizeVal) VALUES (?)');
        $stmt->execute([$new_size_name]);
        
        header('Location: ../pages/admin_page.php'); 
        exit();
    }

    if (isset($_POST['delete_size'])) {
        $size_id_to_delete = $_POST['size_id_to_delete'];
        
        $stmt = $db->prepare('DELETE FROM Item WHERE Size_ = ?');
        $stmt->execute([$size_id_to_delete]);

        $stmt = $db->prepare('DELETE FROM Size_ WHERE SizeVal = ?');
        $stmt->execute([$size_id_to_delete]);
    }

    $stmt = $db->query('SELECT * FROM Size_');
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Location: ../pages/admin_page.php');
    exit();
}
header('Location: ../pages/admin_page.php'); 
exit();
?>