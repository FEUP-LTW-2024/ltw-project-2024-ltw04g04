

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
});



function updateSubtotal(subtotal) {
    var subtotalElement = document.getElementById("subtotal");
    if (subtotalElement) {
        subtotalElement.textContent = "Subtotal: $" + subtotal.toFixed(2);
    }
}
