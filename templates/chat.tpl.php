<?php declare(strict_types = 1); ?>

<?php function getUsersWithUserId(PDO $db, int $userId, array $messages): array {
    $users = [];
    foreach ($messages as $message) {
        if ($message->senderId !== $userId && !in_array($message->senderId, $users)) {
            $users[] = $message->senderId;
        }
        else if ($message->receiverId !== $userId && !in_array($message->receiverId, $users)) {
            $users[] = $message->receiverId;
        }
    }
    return $users;
} ?>


<?php function getMessagesWithUserId(int $userId, array $messages): array {
    $messages_user = [];
    foreach ($messages as $message) {
        if ($message->senderId === $userId || $message->receiverId === $userId) {
            $messages_user[] = $message;
        }
    }
    return $messages_user;   
} ?>


<?php function drawChat(array $users, array $messages, int $currentUserId) { ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../templates/chat.js" ></script>
    
    <body>
        <main>
            <h1 id="myMessages">Messages</h1>
            <?php if (empty($users)): ?> <p> You don't have messages </p>
            <?php else: ?>
            <section id="chat">
                <div id="listContainer">
                    <ul id="listUsers">
                        <?php foreach ($users as $user) : ?>
                            <li class="itemUser" onclick="changeConversation('<?= $user ?>')">User <?= $user ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div id="messageContainer">
                    <div id ="messages">
                        <!-- Mensagens carregadas via AJAX -->
                    </div>

                    <form id="messageForm">
                        <input type="text" id="messageInput" placeholder="Enter your message...">
                        <button type="submit" id="sendMessageButton">
                            <img id="sendButton" src="../pages/imgs/send-icon.png" alt="Send message">
                        </button>
                    </form>
                </div>
                    
            </section>
            <?php endif; ?>
        </main>
    </body>

<?php } ?>