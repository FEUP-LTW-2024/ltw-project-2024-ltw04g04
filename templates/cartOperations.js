

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


document.addEventListener("DOMContentLoaded", function() {
    const heartIcon = document.getElementById('heart-icon');

    if (heartIcon) {
        const itemId = heartIcon.parentElement.dataset.itemId; 
        const initialActive = heartIcon.classList.contains('active');

        if (initialActive) {
            heartIcon.style.color = 'blue';
        }

        heartIcon.addEventListener('click', function() {
            const action = heartIcon.classList.contains('active') ? 'remove-from-wishlist' : 'add-to-wishlist';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/../actions/action_wish_list.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log("Wishlist item operation successful");
                        if (action === 'add-to-wishlist') {
                            heartIcon.classList.add('active');
                            heartIcon.style.color = 'blue'; 
                            console.log("SIM");
                        } else {
                            heartIcon.classList.remove('active');
                            heartIcon.style.color = ''; 
                            console.log("NAO");
                        }
                    } else {
                        console.error("Error: " + xhr.status);
                    }
                }
            };
            xhr.send('itemId=' + itemId + '&action=' + action);
        });
    } else {
        console.error("Element with ID 'heart-icon' not found");
    }
});

