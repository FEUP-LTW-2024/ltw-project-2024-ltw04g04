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
                $messageId = $row['ChatMessageId'] ?? 0;
                $senderId = $row['SenderId'] ?? 0;
                $receiverId = $row['ReceiverId'] ?? 0;
                $messageContent = $row['Message_'] ?? '';
                $date = $row['Date_'] ?? '';
                $time = $row['Time_'] ?? '';
            
                $message = new Message(
                    $messageId,
                    $senderId,
                    $receiverId,
                    $messageContent,
                    $date,
                    $time
                );
                $messages[] = $message;
            }
            return $messages;
        }

        static function saveMessageToDatabase(PDO $db, int $senderId, int $receiverId, string $message, string $date, string $time) {
            $stmt = $db->prepare('
                INSERT INTO ChatMessage (SenderId, ReceiverId, Message_, Date_, Time_)
                VALUES (?, ?, ?, ?, ?)
            ');
            $stmt->execute(array($senderId, $receiverId, $message, $date, $time));
        }
    }
?>