var userId2;
var userName2;
var isLogin = false;

function scrollToBottom() {
    var scrollBar = document.getElementById("messages");
    scrollBar.scrollTop = scrollBar.scrollHeight;
}

function changeConversation(userId, userName) {
    userId2 = userId;
    userName2 = userName;
    $.ajax({
        url: '../actions/action_load_messages.php',
        method: 'GET',
        data: { user_id2: userId2 },
        success: function(data) {
            $('#messages').html(data);
            $('#actualConv').html(userName2);
            scrollToBottom();
        }
    });
}


$(document).ready(function() {  
    if (isLogin) {
        function loadMessages() {
            $.ajax({
                url: '../actions/action_load_messages.php', 
                type: 'GET',
                data: { user_id2: userId2 },
                success: function(response) {
                    $('#messages').html(response);  // Atualiza o conteúdo da div com as mensagens
                }
            });
        }
        loadMessages();
    
        
        $('#messageForm').submit(function(event) {
            event.preventDefault(); 
    
            var message = $('#messageInput').val();
    
            $.ajax({
                url: '../actions/action_send_message.php', 
                type: 'POST',
                data: { message: message, user_id2: userId2 },
                success: function(response) {
                    $('#messageInput').val('');      // Limpa o campo de mensagem após o envio
                    loadMessages();
                }
            });
        });
    
        setInterval(loadMessages, 5000);
    }  
});
