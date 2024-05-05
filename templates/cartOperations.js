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
                        // If the operation is successful, reload the page or update the UI as needed
                        window.location.reload();
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

function updateSubtotal() {
    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure the request
    xhr.open("GET", "../database/ShoppingCart.class.php", true);

    // Set up the callback function
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Parse the JSON response
                var response = JSON.parse(xhr.responseText);
                // Update the subtotal element
                document.getElementById("subtotal").textContent = "Subtotal: $" + response.total.toFixed(2);
            } else {
                console.error("Error: " + xhr.status);
            }
        }
    };

    // Send the request
    xhr.send();
}



