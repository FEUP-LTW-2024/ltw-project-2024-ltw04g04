$(document).ready(function() {
    function updateCart() {
        $.ajax({
            url: '../actions/action_update_cart.php',
            method: 'GET',
            success: function(response) {
                $('#items').html(response); 
            }
        });
    }

    updateCart();
    setInterval(updateCart, 5000);
});