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
    $messages = Message::getMessagesWithUserId($db, $userId);
    $users = getUsersWithUserId($db, $userId, $messages);
    drawChat($users, $messages, $userId);
?>