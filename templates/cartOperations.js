

document.addEventListener("DOMContentLoaded", function() {
    var addToCartButton = document.getElementById("addItemToCart");
    
    if (addToCartButton) {
        addToCartButton.addEventListener("click", function() {
            var itemId = this.getAttribute("data-item-id");
            itemReqs(itemId, 'add');
        });
    }
});



function itemReqs(itemId, action) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../database/shoppingCart.class.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    if (action === 'add') {
                        alert("Item added to cart successfully");
                    } 
                    else if (action === 'remove') {
                        window.location.reload();
                    }
                    else if (action === 'total') {
                        updateSubtotal(response.subtotal);
                        window.location.reload();
                    }
                    else {
                        window.location.reload();
                    }
                } else {
                    console.error(response.error);
                }
            } else {
                console.error("Error: " + xhr.status);
            }
        }
    };
    xhr.send("itemId=" + itemId + "&action=" + action);
}

document.addEventListener("DOMContentLoaded", function() {
    var removeButtons = document.querySelectorAll(".remove-button");
    
    removeButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var itemId = this.getAttribute("data-item-id");
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "/../actions/action_cart.php", true);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log("Item removed successfully");
                        window.location.reload();
                    } else {
                        console.error("Error: " + xhr.status);
                    }
                }
            };

            xhr.send("itemId=" + itemId + "&action=remove");
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var increaseButtons = document.querySelectorAll(".increase-button");
    
    increaseButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var itemId = this.getAttribute("data-item-id");
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "/../actions/action_cart.php", true);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log("Item quantity increased successfully");
                        window.location.reload();
                    } else {
                        console.error("Error: " + xhr.status);
                    }
                }
            };

            xhr.send("itemId=" + itemId + "&action=add");
        });
    });
});


function updateSubtotal(subtotal) {
    var subtotalElement = document.getElementById("subtotal");
    if (subtotalElement) {
        subtotalElement.textContent = "Subtotal: $" + subtotal.toFixed(2);
    }
}
