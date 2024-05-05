<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../database/message.class.php');


$db = getDatabaseConnection();
$session = new Session();
$userId = $session->getUserId();
$userId2 = intval($_GET['user_id2']);
$messages = Message::getMessagesWithUserId($db, $userId, $userId2);

foreach ($messages as $message) {
    echo '<div class="message ' . ($message->senderId === $userId ? 'userAt' : 'userTo') . '" id="user' 
                    . ($message->senderId === $userId ? $message->receiverId : $message->senderId) . '">';
    echo '<p>Date: ' . $message->date . '</p>';
    echo '<p>Time: ' . $message->time . '</p>';
    echo '<p>' . $message->message . '</p>';
    echo '</div>';
}

?>