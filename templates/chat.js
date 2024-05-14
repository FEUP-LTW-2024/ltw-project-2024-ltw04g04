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

    // Atualiza o valor do campo hidden
    document.getElementById('userId2Input').value = userId2;

    fetch(`../actions/action_load_messages.php?user_id2=${userId2}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('messages').innerHTML = data;
            document.getElementById('actualConv').innerHTML = userName2;
            scrollToBottom();
        })
        .catch(error => console.error('Error:', error));
}

function sendForm() {
    // Pegar os valores do formulário
    const message = document.getElementById('messageInput').value;
    const userId2 = document.getElementById('userId2Input').value;

    // Construir a URL com o ID do usuário como parâmetro de consulta
    const url = '../actions/action_send_message.php?user_id2=' + userId2;

    // Redirecionar a página para a URL construída
    window.location.href = url;

    // Retornar false para evitar o envio padrão do formulário
    // O redirecionamento ocorre antes que o formulário seja enviado
    return false;
}

/*
document.addEventListener("DOMContentLoaded", function() {
    if (isLogin) {
        function loadMessages() {
            fetch(`../actions/action_load_messages.php?user_id2=${userId2}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('messages').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }
        loadMessages();
    
        document.getElementById('messageForm').addEventListener('submit', function(event) {
            event.preventDefault(); 
    
            var message = document.getElementById('messageInput').value;
    
            fetch('../actions/action_send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ message: message, user_id2: userId2 })
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('messageInput').value = '';  // Limpa o campo de mensagem após o envio
                loadMessages();
            })
            .catch(error => console.error('Error:', error));
        });
    
        setInterval(loadMessages, 5000);
    }  
});
*/