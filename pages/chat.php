<?php declare(strict_types = 1); 
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/message.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/chat.tpl.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $categories = getCategories();
    generateNavigationMenu($session, $categories);

    if ($session->isLogin()) {
        $userId = $session->getUserId();
        $users = Message::getUsersWithUserId($db, $userId);
    } else {
        $users = [];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $chatId = (int)$_POST['chatId'];
        $initialChat = $chatId;

        if (!in_array($chatId, $users)) {
            $users[] = $chatId;
        }
    } else {
        $initialChat = -1;
    }
    
    drawChat($db, $session, $users, $initialChat);
    generateFooter();
?>