<!DOCTYPE html>
<html>
<?php 
include 'navigation.php'; 
require_once(__DIR__ . '/../actions/actions.php');
$categories = getCategories();
generateNavigationMenu($categories);
?>
<body>
    <main>
        <section id="item">
            <div id="itemImg"><img src="imgs/itemTemplate.png" alt="Image of item"></div>   <!-- CHANGE -->
            
            <div id="containers">
            <div id="itemContainer">
                <h2>Product Name</h2>       <!-- CHANGE -->
                <button type="button" id="addItemToCart">Add to shopping cart</button>
            </div>

            <div id="itemContainer">
                <h3>Seller Name</h3>       <!-- CHANGE -->
                <button type="button" id="accountSeller"> > </button>
            </div>
            </div>

        </section>
    </main> 
</body>
</html>
