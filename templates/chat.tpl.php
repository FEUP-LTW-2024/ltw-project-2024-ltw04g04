<?php declare(strict_types = 1); ?>

<?php function drawChat(PDO $db, Session $session) { ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../templates/chat.js" ></script>
    
    <?php 
        $currentUserId = $session->getUserId();
        if ($session->isLogin()) {
            echo "<script> isLogin = true; </script>";
            $users = Message::getUsersWithUserId($db, $currentUserId);
            if (!empty($users)) {
                echo "<script>changeConversation(" . $users[0] . ");</script>";
                $name = User::getUserWithId($db, $users[0])->name;
            }
        }
    ?>
    
    <body>
        <main>
            <h1 id="myMessages">Messages</h1>
            <?php if (!$session->isLogin()) { ?> <p> Please log in to view your messages. </p>
            <?php } else if (empty($users)) { ?> <p> You don't have messages </p>
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
            <?php } ?>
        </main>
    </body>

<?php } ?>