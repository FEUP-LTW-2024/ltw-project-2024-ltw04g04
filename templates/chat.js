$(document).ready(function() {
    function loadMessages() {
        $.ajax({
            url: '../actions/action_load_messages.php', 
            type: 'GET',
            success: function(response) {
                $('#messages').html(response); // Atualiza o conteúdo da div com as mensagens
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
            data: { message: message },
            success: function(response) {
                $('#messageInput').val('');      // Limpa o campo de mensagem após o envio
                loadMessages();
            }
        });
    });

    setInterval(loadMessages, 5000);
});

/*function changeConversation(userId) {
    var conversationHeader = document.querySelector('.messageContainer h2');
    conversationHeader.textContent = "Current Conversation: User " + userId;

    // Ocultar todas as mensagens
    var allMessages = document.querySelectorAll('.message');
    allMessages.forEach(function(message) {
        message.style.display = 'none';
    });

    // Exibe apenas as mensagens do usuário selecionado
    var messagesToShow = document.querySelectorAll('[id^="user' + userId + '"]');
    messagesToShow.forEach(function(message) {
        message.style.display = 'block';
    });
}
*/