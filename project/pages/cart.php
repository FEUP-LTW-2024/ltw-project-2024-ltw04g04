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
