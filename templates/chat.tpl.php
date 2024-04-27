<?php declare(strict_types = 1); ?>

<?php function drawChat(array $messages, int $currentUserId) { 
    $users = [];
    foreach ($messages as $message) {
        if ($message->senderId !== $currentUserId && !in_array($message->senderId, $users)) {
            $users[] = $message->senderId;
        }
        if ($message->receiverId !== $currentUserId && !in_array($message->receiverId, $users)) {
            $users[] = $message->receiverId;
        }
    }
    ?>
<body>
    <main>
        <h1 id= "myMessages" >Messages</h1>
        <section id="chat">
            <div class="listContainer">
                <ul class="listUsers">
                    <?php foreach ($users as $user) : ?>
                        <li class="itemUser" onclick="changeConversation('<?= $user ?>')">User <?= $user ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="messageContainer">
                <h2>Current Conversation</h2>
                <div class="messages">
                        <?php foreach ($messages as $message) : ?>
                            <div class="message <?= $message->senderId === $currentUserId ? 'user1' : 'user2' ?>">
                                <p>Date: <?= $message->date ?></p>
                                <p>Time: <?= $message->time ?></p>
                                <p><?= $message->message ?></p>
                            </div>
                        <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main> 
</body>

<?php } ?>