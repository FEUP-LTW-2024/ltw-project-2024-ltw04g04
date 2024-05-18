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

    if (isset($_POST['add_condition'])) {
        $new_condition_name = $_POST['new_condition_name'];
        
        $stmt = $db->prepare('INSERT INTO Condition(ConditionName) VALUES (?)');
        $stmt->execute([$new_condition_name]);
        
        header('Location: ../pages/admin_page.php'); 
        exit();
    }

    if (isset($_POST['delete_condition'])) {
        $condition_id_to_delete = $_POST['condition_id_to_delete'];
        
        $stmt = $db->prepare('DELETE FROM Item WHERE Condition = ?');
        $stmt->execute([$condition_id_to_delete]);

        $stmt = $db->prepare('DELETE FROM Condition WHERE ConditionName = ?');
        $stmt->execute([$condition_id_to_delete]);
    }

    $stmt = $db->query('SELECT * FROM Condition');
    $conditions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Location: ../pages/admin_page.php');
    exit();
}
header('Location: ../pages/admin_page.php'); 
exit();
?>