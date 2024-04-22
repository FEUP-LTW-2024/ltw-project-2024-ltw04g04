<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/session.php');
?>

<?php function generateNavigationMenu(Session $session, array $categories) { ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
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
              
                <div id="filter"><a href="filter.php"><img src="imgs/filter-icon.png" class="filter" alt="Filter"></a></div>
                <div id="account">
                    <a href="<?php echo $session->isLogin() ? 'account.php' : 'login.php'; ?>">
                        <img src="imgs/user-icon.png" class="account" alt="Account">
                    </a>
                </div>
                <div id="favourite"><a href="favourite.php"><img src="imgs/heart-icon.png" class ="favourite" alt="Favourite"></a></div>
                <div id="cart"><a href="cart.php"><img src="imgs/cart-icon.jpg" class ="cart"  alt="Cart"></a></div>

            </nav>
        </header>
        <nav id="menu">
            <ul>
                <?php foreach ($categories as $category) : ?>
                    <li><a href="index.html"><?php echo $category['CategoryName']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </body>
    </html>
    
<?php } ?>
