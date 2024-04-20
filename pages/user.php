


<!DOCTYPE html>
<html>
<?php 
include 'navigation.php'; 
require_once(__DIR__ . '/../actions/actions.php');
$categories = getCategories();
generateNavigationMenu($categories);
 ?>
      <main>
        <section id="profile">
            <div id="avatar"><img src="imgs/avatar.png" alt="User Avatar"></div>
            <div id="userInfo">
                <h1>UserX</h1>
                <form action="/updateProfile" method="post" class =  "editForm">
                    <h2>Profile</h2>
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="" placeholder="Name ...">

                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="" placeholder= "E-mail ...">

                    <label for= "location">Location</label>
                    <input type= "text" id= "location"name= "location"value="" placeholder= "Location ...">
                    
                    <!-- Add more fields as needed -->
                    
                </form>
            </div>

            <!-- Follow button -->
            <button type = "button"id = "followButton">Edit</button>

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