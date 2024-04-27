<?php declare(strict_types = 1); ?>

<?php function drawChat() { ?>
<body>
    <main>
        <h1 id= "myMessages" >Messages</h1>
        <section id="chat">
            <div class="listContainer">
                <ul class="listUsers">
                    <li class="itemUser" onclick="changeConversation('User 1')">User 1</li>
                    <li class="itemUser" onclick="changeConversation('User 2')">User 2</li>
                    <li class="itemUser" onclick="changeConversation('User 3')">User 3</li>
                </ul>
            </div>

            <div class="messageContainer">
                <h2>Current Conversation</h2>
                <div class="messages" id="current-conversation">
                    <!-- Messages of current here -->
                </div>
            </div>
        </section>
    </main> 
</body>

<?php } ?>