

document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("increase-button")) {
            var itemId = event.target.getAttribute("data-item-id");
            addItemToCart(itemId, 'add');
        }
    });

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("decrease-button")) {
            var itemId = event.target.getAttribute("data-item-id");
            addItemToCart(itemId, 'decrease');
        }
    });

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("remove-button")) {
            var itemId = event.target.getAttribute("data-item-id");
            addItemToCart(itemId, 'remove');
        }
    });

    var addToCartButton = document.getElementById("addItemToCart");
    if (addToCartButton) {
        addToCartButton.addEventListener("click", function() {
            var itemId = this.getAttribute("data-item-id");
            addItemToCart(itemId);
        });
    }


    function addItemToCart(itemId, action = 'add') {
        var xhr = new XMLHttpRequest();
    
        xhr.open("POST", "/../actions/action_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    updateCart();
                    updateSummary();
                } else {
                    console.error("Error: " + xhr.status);
                }
            }
        };
    
        xhr.send("itemId=" + itemId + "&action=" + action);
    }
    
    function updateCart() {
        $.ajax({
            url: '../actions/action_update_cart.php',
            method: 'GET',
            success: function(response) {
                $('#items').html(response); // Atualize o conteúdo do carrinho
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }
    function updateSummary() {
        $.ajax({
            url: '../actions/action_update_summary.php',
            method: 'GET',
            success: function(response) {
                $('#summary').html(response); 
            }
        });
    }
});


function updateSubtotal(subtotal) {
    var subtotalElement = document.getElementById("subtotal");
    if (subtotalElement) {
        subtotalElement.textContent = "Subtotal: $" + subtotal.toFixed(2);
    }
}

// Função para adicionar ou remover um item da lista de desejos
function toggleWishlist(itemId) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/../actions/action_wish_list.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
                updateHeartIconStyle(itemId, response.isInWishlist);
            } else {
                alert(response.error);
            }
        }
    };
    xhr.send('itemId=' + encodeURIComponent(itemId));
}

// Função para obter os IDs dos itens da lista de desejos
function getItemIds() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '/../actions/action_get_item_ids.php', false); // Síncrono
    xhr.send();
    if (xhr.readyState === 4 && xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        return response.itemIds;
    }
    return [];
}

// Chamada inicial para atualizar o estilo do ícone do coração
// para cada item na página após o carregamento da página
window.onload = function() {
    let itemIds = getItemIds();
    itemIds.forEach(function(itemId) {
        updateHeartIconStyle(itemId);
    });
};

















