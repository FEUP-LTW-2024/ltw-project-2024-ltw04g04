

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

function updateHeartIconStyle(itemId) {
    let heartIcon = document.getElementById('heart-icon');
    let isInWishlist = localStorage.getItem('wishlist_' + itemId); 
    if (isInWishlist === 'true') {
        heartIcon.classList.add('in-wishlist');
    } else {
        heartIcon.classList.remove('in-wishlist');
    }
}

function updateWishlistState(itemId, isInWishlist) {
    localStorage.setItem('wishlist_' + itemId, isInWishlist); 
}

document.addEventListener("DOMContentLoaded", function() {
    let heartIcon = document.getElementById('heart-icon');
    if (heartIcon) {
        let itemId = heartIcon.dataset.itemId; 
        updateHeartIconStyle(itemId); 
        heartIcon.addEventListener('click', function() {
            let itemId = this.dataset.itemId;
            toggleWishlist(itemId); 
        });
    } else {
        console.error("Element with ID 'heart-icon' not found");
    }
});

function toggleWishlist(itemId) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/../actions/action_wish_list.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
                //alert(response.success);
                updateWishlistState(itemId, response.isInWishlist);
                updateHeartIconStyle(itemId);
            } else {
                alert(response.error);
            }
        }
    };
    xhr.send('itemId=' + encodeURIComponent(itemId));
}; 











