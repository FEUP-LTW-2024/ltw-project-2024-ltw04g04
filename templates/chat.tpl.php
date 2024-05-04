<?php declare(strict_types = 1); ?>


<?php function drawChat(PDO $db, int $currentUserId) { ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../templates/chat.js" ></script>
    
    <?php 
        $users = Message::getUsersWithUserId($db, $currentUserId);
        if (!empty($users)) {
            echo "<script>changeConversation(" . $users[0] . ");</script>";
        }
    ?>
    
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