<?php
    declare(strict_types = 1);

    class Message {
        public int $messageId;
        public int $sellerId;
        public int $buyerId;
        public string $message;
        public string $date;
        public string $time;

        public function __construct(int $messageId, int $sellerId, int $buyerId, string $message, string $date, string $time) {
            $this->messageId = $messageId;
            $this->sellerId = $sellerId;
            $this->buyerId = $buyerId;
            $this->message = $message;
            $this->date = $date;
            $this->time = $time;
        }

        static function getMessageWithId(PDO $db, int $userId): Item {
            $stmt = $db->prepare('
                SELECT ChatMessageId, SellerId, BuyerId, Message_, Date_, Time_
                FROM ChatMessage
                WHERE SellerId = ? OR BuyerId = ?
            ');

            $stmt->execute(array($itemId));
            
            if ($message = $stmt->fetch()) {
                return new Message(
                $item['ChatMessageId'],
                $item['SellerId'],
                $item['BuyerId'],
                $item['Message_'],
                $item['Date_'],
                $item['Time_'],
                );
            } else return null;
        }

    }
?>