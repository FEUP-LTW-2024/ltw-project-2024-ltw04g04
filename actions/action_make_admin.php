<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../utils/utils.php');

$session = new Session();
$db = getDatabaseConnection();

if ($session->isAdmin() && $_SESSION['csrf'] === $_POST['csrf']) {
    if (isset($_POST['user_id']) && isset($_POST['action'])) {
        $user_id = cleanIntInput(intval($_POST['user_id']));
        $action = cleanInput($_POST['action']);
    
        if ($action === 'make_admin') {
            User::upgradeUserToAdmin($db, $user_id);
        } elseif ($action === 'remove_admin') {
            User::downgradeUser($db, $user_id);
        }
    
        $user = User::getUserWithId($db, $user_id);
        echo json_encode([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'csrf' => $_SESSION['csrf'],
                'isAdmin' => $user->isAdmin
            ]
        ]);
        exit();
    }
}

echo json_encode(['success' => false, 'error' => 'Invalid']);
exit();
?>