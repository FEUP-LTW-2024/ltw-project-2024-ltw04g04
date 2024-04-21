<!DOCTYPE html>
<html>
<?php 
    include 'navigation.php'; 
    require_once(__DIR__ . '/../actions/actions.php');
    $categories = getCategories();
    generateNavigationMenu($categories); 
?>

    <main>
        <h1 id= "myCart" >My Shopping Cart</h1>
        <section id="shoppingCart">
            <section id="items">
                   
            </section>
            <section id="summary">
                <h1>Order Summary</h1>
                <p>Subtotal: 0.00$</p>
                <button>Checkout</button>   
            </section>
        </section>
    </main>
</body>
</html>
