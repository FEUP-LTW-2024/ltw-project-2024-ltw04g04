<?php declare(strict_types = 1); 
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/message.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/chat.tpl.php');

    $session = new Session();
    $categories = getCategories();
    generateNavigationMenu($session, $categories);

    $db = getDatabaseConnection();
    $userId = $session->getUserId();

    $users = Message::getUsersWithUserId($db, $userId);
    $initialChat = -1;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $chatId = (int)$_POST['chatId'];
        $initialChat = $chatId;

        if (!in_array($chatId, $users)) {
            $users[] = $chatId;
        }
    }
    drawChat($db, $session, $users, $initialChat);
    generateFooter();
?>