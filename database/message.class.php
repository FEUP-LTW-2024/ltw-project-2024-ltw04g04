<?php
    declare(strict_types = 1);

    class Message {
        public int $messageId;
        public int $senderId;
        public int $receiverId;
        public string $message;
        public string $date;
        public string $time;

        public function __construct(int $messageId, int $senderId, int $receiverId, string $message, string $date, string $time) {
            $this->messageId = $messageId;
            $this->senderId = $senderId;
            $this->receiverId = $receiverId;
            $this->message = $message;
            $this->date = $date;
            $this->time = $time;
        }

        static function getMessagesWithUserId(PDO $db, int $userId): array {
            $messages = [];
            $stmt = $db->prepare('
                SELECT ChatMessageId, SenderId, ReceiverId, Message_, Date_, Time_
                FROM ChatMessage
                WHERE SenderId = ? OR ReceiverId = ?
            ');
            $stmt->execute([$userId, $userId]);
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $message = new Message(
                    $row['ChatMessageId'],
                    $row['SenderId'],
                    $row['ReceiverId'],
                    $row['Message_'],
                    $row['Date_'],
                    $row['Time_']
                );
                $messages[] = $message;
            }
            return $messages;
        }
    }
?>