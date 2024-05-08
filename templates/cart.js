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

    function updateSummary() {
        $.ajax({
            url: '../actions/action_update_summary.php',
            method: 'GET',
            success: function(response) {
                $('#summary').html(response); 
            }
        });
    }

    updateCart();
    updateSummary();
    setInterval(updateCart, 5000);
    setInterval(updateSummary, 5000);
});