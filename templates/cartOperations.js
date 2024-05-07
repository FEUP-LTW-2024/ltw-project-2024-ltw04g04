

document.addEventListener("DOMContentLoaded", function() {
    var increaseButtons = document.querySelectorAll(".increase-button");
    var removeButtons = document.querySelectorAll(".remove-button");
    var addToCartButton = document.getElementById("addItemToCart");

    increaseButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            handleQuantityChange(this, 'add');
        });
    });

    removeButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            handleQuantityChange(this, 'remove');
        });
    });

    if (addToCartButton) {
        addToCartButton.addEventListener("click", function() {
            var itemId = this.getAttribute("data-item-id");
            addItemToCart(itemId);
        });
    }

    function handleQuantityChange(button, action) {
        var itemId = button.getAttribute("data-item-id");
        addItemToCart(itemId, action);
    }

    function addItemToCart(itemId, action = 'add') {
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "/../actions/action_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log("Item quantity changed successfully");
                    window.location.reload();
                } else {
                    console.error("Error: " + xhr.status);
                }
            }
        };

        xhr.send("itemId=" + itemId + "&action=" + action);
    }
});


function updateSubtotal(subtotal) {
    var subtotalElement = document.getElementById("subtotal");
    if (subtotalElement) {
        subtotalElement.textContent = "Subtotal: $" + subtotal.toFixed(2);
    }
}


// Função para enviar solicitação AJAX para adicionar/remover itens da lista de desejos
function toggleWishlist(itemId) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/../actions/action_wish_list.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.success); 
                let heartIcon = document.getElementById('heart-icon');
                if (response.isInWishlist) {
                    heartIcon.style.color = 'blue';
                } else {
                    heartIcon.style.color = ''; 
                }
            } else {
                alert(response.error);
            }
        }
    };
    console.log(itemId);
    xhr.send('itemId=' + encodeURIComponent(itemId));
}







