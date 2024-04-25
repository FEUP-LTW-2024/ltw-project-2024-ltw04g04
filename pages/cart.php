<!DOCTYPE html>
<html>
<?php 
    
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/get_database.php');
    require_once(__DIR__ . '/../templates/navigation.php');

    $session = new Session();
    $categories = getCategories();
    generateNavigationMenu($session, $categories);
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
