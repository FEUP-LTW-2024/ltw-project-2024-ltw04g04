<?php declare(strict_types=1); ?>

<?php function drawChat(PDO $db, Session $session) { ?>
    <script src="../templates/chat.js"></script>
    
    <?php 
        if ($session->isLogin()) {
            echo "<script> isLogin = true; </script>";
            $userId = $session->getUserId();
            $users = Message::getUsersWithUserId($db, $userId);

            $chatId = $session->getChatId();
            if (!$chatId) {
                $chatId = $users[0];
            } 
            $name = User::getUserWithId($db, $chatId)->name;
            $messages = Message::getMessagesWithUserId($db, $userId, $chatId);
        }
    ?>
    
    <body>
        <main>
            <h1 id="myMessages">Messages</h1>
            <?php if (!$session->isLogin()) { ?> 
                <p> Please log in to view your messages. </p>
            <?php } else if (empty($users)) { ?> 
                <p> You don't have messages </p>
            <?php } else { ?>
                <section id="chat">
                    <div id="listContainer">
                        <ul id="listUsers">
                            <?php foreach ($users as $user) : ?>
                                <?php $nameUser = User::getUserWithId($db, $user)->name; ?>
                                <li class="itemUser" onclick="changeConversation('<?= $user ?>', '<?= $nameUser ?>')"> <?= $nameUser ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div id="messageContainer">
                        <h2 id="actualConv"> <?= $name ?> </h2>
                        <div id="messages">
                            <?php if (!empty($messages)) {
                                foreach ($messages as $message) { ?>
                                    <div class="message <?= ($message->senderId === $currentUserId ? 'userAt' : 'userTo') ?>" id="user<?= ($message->senderId === $currentUserId ? $message->receiverId : $message->senderId) ?>">
                                    <p>Date: <?php echo $message->date ?> </p>
                                    <p>Time: <?php echo $message->time ?> </p>
                                    <p> <?php echo $message->message ?> </p>
                                    </div>
                                    
                                <?php }
                            } ?>
                        </div>

                        <form id="messageForm" action="../actions/action_send_message.php" method="post">
                            <input type="text" id="messageInput" name="message" placeholder="Enter your message...">
                            <input type="hidden" id="userId2Input" name="user_id2" value="<?= $currentUser ?>">
                            <button type="submit" id="sendMessageButton">
                                <img id="sendButton" src="../pages/imgs/send-icon.png" alt="Send message">
                            </button>
                        </form>
                    </div>
                </section>
            <?php } ?>
        </main>
    </body>
<?php } ?>
