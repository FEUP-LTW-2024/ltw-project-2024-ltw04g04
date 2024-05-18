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

    if (isset($_POST['add_model'])) {
        $new_model_name = $_POST['new_model_name'];
        
        $stmt = $db->prepare('INSERT INTO Model(ModelName) VALUES (?)');
        $stmt->execute([$new_model_name]);
        
        header('Location: ../pages/admin_page.php'); 
        exit();
    }

    if (isset($_POST['delete_model'])) {
        $model_id_to_delete = $_POST['model_id_to_delete'];
        
        $stmt = $db->prepare('DELETE FROM Item WHERE Model = ?');
        $stmt->execute([$model_id_to_delete]);

        $stmt = $db->prepare('DELETE FROM Model WHERE ModelName = ?');
        $stmt->execute([$model_id_to_delete]);
    }

    $stmt = $db->query('SELECT * FROM Model');
    $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Location: ../pages/admin_page.php');
    exit();
}
header('Location: ../pages/admin_page.php'); 
exit();
?>