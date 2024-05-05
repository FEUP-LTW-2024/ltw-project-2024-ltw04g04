

document.addEventListener("DOMContentLoaded", function() {
    var addToCartButton = document.getElementById("addItemToCart");
    
    addToCartButton.addEventListener("click", function() {
        var itemId = this.getAttribute("data-item-id");

        itemReqs(itemId, 'add');
    });

});


function itemReqs(itemId, action) {
    // Make an AJAX request to perform the specified action on the item
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../database/ShoppingCart.class.php", true); // Corrected URL
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

function updateSubtotal(subtotal) {
    var subtotalElement = document.getElementById("subtotal");
    if (subtotalElement) {
        subtotalElement.textContent = "Subtotal: $" + subtotal.toFixed(2);
    }
}
