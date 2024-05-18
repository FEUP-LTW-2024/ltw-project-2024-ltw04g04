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

    if (isset($_POST['add_brand'])) {
        $new_brand_name = $_POST['new_brand_name'];
        
        $stmt = $db->prepare('INSERT INTO Brand(BrandName) VALUES (?)');
        $stmt->execute([$new_brand_name]);
        
        header('Location: ../pages/admin_page.php'); 
        exit();
    }

    if (isset($_POST['delete_brand'])) {
        $brand_id_to_delete = $_POST['brand_id_to_delete'];
        
        $stmt = $db->prepare('DELETE FROM Item WHERE Brand = ?');
        $stmt->execute([$brand_id_to_delete]);

        $stmt = $db->prepare('DELETE FROM Brand WHERE BrandName = ?');
        $stmt->execute([$brand_id_to_delete]);
    }

    $stmt = $db->query('SELECT * FROM Brand');
    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Location: ../pages/admin_page.php');
    exit();
}
header('Location: ../pages/admin_page.php'); 
exit();
?>