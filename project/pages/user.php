<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/x-icon" href="imgs/logo.png">
</head>
<body>
    <header>
        <nav id="navbar">
            <div><img id="logo" src="imgs/logo.png"  alt="Logo"></div>
            <div id="search">
                <form action="search.html" method="get">
                    <div id="searchbar">
                        <input type="text" name="query" placeholder="Search...">
                        <img src="imgs/search-icon.svg">
                    </div>
                </form>
            </div>
          
            <div id="account"><a href="account.php"><img src="imgs/user-icon.png" class ="account" alt="Account"></a></div>
            <div id="favourite"><a href="favourite.php"><img src="imgs/heart-icon.png" class ="favourite" alt="Favourite"></a></div>
            <div id="cart"><a href="cart.php"><img src="imgs/cart-icon.jpg" class ="cart"  alt="Cart"></a></div>

        </nav>
    </header>
    <nav id="menu">
        <ul>
          <li><a href="index.html">Beads and bracelets</a></li>
          <li><a href="index.html">Earrings</a></li>
          <li><a href="index.html">Rings</a></li>
          <li><a href="index.html">Necklaces</a></li>
          <li><a href="index.html">Accessories</a></li>
          <li><a href="index.html">Clocks</a></li>
        </ul>
      </nav>
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
            <button type = "button"id = "followButton">Follow</button>

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