
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
            window.location.href = "../pages/cart.php";
        });
    }


    function addItemToCart(itemId, action = 'add') {
        var xhr = new XMLHttpRequest();
    
        xhr.open("POST", "/../actions/action_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.status);
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
        fetch('../actions/action_update_cart.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('items').innerHTML = data; 
            })
            .catch(error => console.error('Error:', error));
    }

    function updateSummary() {
        fetch('../actions/action_update_summary.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('summary').innerHTML = data; 
            })
            .catch(error => console.error('Error:', error));
    }
});


function updateSubtotal(subtotal) {
    var subtotalElement = document.getElementById("subtotal");
    if (subtotalElement) {
        subtotalElement.textContent = "Subtotal: $" + subtotal.toFixed(2);
    }
}

function updateHeartIconStyle(itemId, isInWishlist) {
    let heartIcon = document.getElementById('heart-icon-' + itemId);
    let iconSrc = isInWishlist ? '/../pages/imgs/heart-icon-painted.png' : '/../pages/imgs/heart-icon.png';
    heartIcon.src = iconSrc;
}

function toggleWishlist(event, itemId) {
    event.preventDefault();
    event.stopPropagation(); 

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/../actions/action_wish_list.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    //alert(response.success);
                    let isInWishlist = response.isInWishlist;
                    updateHeartIconStyle(itemId, isInWishlist);
                } else {
                    alert(response.error);
                }
            } else {
                alert('Error in AJAX acquisition: ' + xhr.statusText);
            }
        }
    };
    xhr.send('itemId=' + encodeURIComponent(itemId));
}

