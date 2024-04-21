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
                <p> price $ </p>       <!-- CHANGE -->
                <button type="button" id="addItemToCart">Add to shopping cart</button>

                <h3>Product details</h3>
                <p> Category: </p>       <!-- CHANGE -->
                <!-- ADD THE OTHER CHARACTERISTICS -->
            </div>

            <div id="sellerContainer">
                <div id="sellerImg"><img src="imgs/user-icon.png" alt="Image of icon account"></div>
                <h3>Seller Name</h3>       <!-- CHANGE -->
                <button type="button" id="accountSeller"> > </button>
            </div>
            </div>

        </section>
    </main> 
</body>
</html>
