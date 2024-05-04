<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/get_database.php');
require_once(__DIR__ . '/../database/message.class.php');

$db = getDatabaseConnection();
$session = new Session();

$message = $_POST['message'];
$senderId = $session->getUserId(); 
$receiverId = 1; // Substitua pelo ID do destinatário da mensagem
$date = date('d/m/Y');
$time = date('H') . 'h' . date('i');

Message::saveMessageToDatabase($db, $senderId, $receiverId, $message, $date, $time);
?>
