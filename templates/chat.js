function changeConversation(userId) {
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