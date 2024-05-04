<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../database/message.class.php');


$db = getDatabaseConnection();
$session = new Session();
$userId = $session->getUserId();
$messages = Message::getMessagesWithUserId($db, $userId);

foreach ($messages as $message) {
    echo '<div class="message">';
    echo '<p>Date: ' . $message->date . '</p>';
    echo '<p>Time: ' . $message->time . '</p>';
    echo '<p>' . $message->message . '</p>';
    echo '</div>';
}

?>