<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../database/message.class.php');
    
    $db = getDatabaseConnection();
    $session = new Session();
    
    $message = $_POST['message'];
    $senderId = $session->getUserId(); 
    $receiverId = (int)$_POST['user_id2'];
    $date = date('d/m/Y');
    $time = date('H') . 'h' . date('i');
    
    Message::saveMessageToDatabase($db, $senderId, $receiverId, $message, $date, $time);

    $redirectUrl = "../pages/chat.php?chat_id=$receiverId"; 
    header("Location: $redirectUrl");
    exit;
?>