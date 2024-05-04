var userId2;

function changeConversation(userId) {
    userId2 = userId;
    $.ajax({
        url: '../actions/action_load_messages.php',
        method: 'GET',
        data: { user_id2: userId2 },
        success: function(data) {
            $('#messages').html(data);
        }
    });
}


$(document).ready(function() {
    
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
});
