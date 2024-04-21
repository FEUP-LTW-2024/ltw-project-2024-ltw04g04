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
            <div id="itemContainer">
                <form action="/updateProfile" method="post" class =  "editForm">
                    <h2>Product Name</h2>       <!-- CHANGE -->
                    

                    <button type="button" id="addItemToCart">Add to shopping cart</button>
                </form>
            </div>

            <!-- Follow button -->
            

        </section>

        <!-- Articles Section -->
        <section id = "articles">
            <!-- Article 1 -->
            <article class ="articleItem">
                <!-- Image of article 1 -->
                <!-- You need to replace 'article1.jpg' with actual path of your image-->
                <img src ="imgs/article1.jpg"class ="articleImage"alt ="Article 1 Image">

                <!-- Description of article 1-->
                <!--<p> Description about this article.</p>-->
                
            </article>

            <!-- Add more articles as needed -->

        </section> 
    </main> 
</body>
</html>
