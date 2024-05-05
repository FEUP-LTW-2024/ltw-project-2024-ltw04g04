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
                <div><a href="index.php"><img id="logo" src="imgs/logo.png"  alt="Logo"></a></div>
                <div id="search">
                    <form action="search.html" method="get">
                        <div id="searchbar">
                            <input type="text" name="query" placeholder="Search...">
                            <img src="imgs/search-icon.svg">
                        </div>
                    </form>
                </div>

                <div id="filter-container">
                    <div id="filter">
                        <span class="arrow">&#9652;</span>
                    </div>

                    <div id="filter-box">
                        <?php require_once(__DIR__ . '/../pages/filter.php'); ?>
                    </div>
                </div>

                <div id="account">
                    <?php if ($session->isLogin()) : ?>
                        <div class="dropdown">
                            <img src="imgs/user-icon.png" class="account" alt="Account">
                            <div class="dropdown-content">
                                <a href="account.php">Profile</a>
                                <a href="/../actions/action_logout.php">Logout</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="/../pages/login.php">
                            <img src="imgs/user-icon.png" class="account" alt="Account">
                        </a>
                    <?php endif; ?>
                </div>
                <div id="favourite"><a href="favourite.php"><img src="imgs/heart-icon.png" class="favourite" alt="Favourite"></a></div>
                <div id="cart"><a href="cart.php"><img src="imgs/cart-icon.jpg" class="cart"  alt="Cart"></a></div>
                <div id="chatMsg"><a href="chat.php"><img src="imgs/message-icon.png" class="chatMsg"  alt="Chat"></a></div>

            </nav>
        </header>
        <nav id="menu">
            <ul>
                <?php foreach ($categories as $category) : ?>
                    <li><a href="index.html"><?php echo $category['CategoryName']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <script src="script.js"></script>
    </body>
    </html>
<?php } ?>

<?php function drawHeaderForm(bool $login) { ?>
    <!DOCTYPE html>
    <html>
        <body>
            <head>
                <link rel="stylesheet" type="text/css" href="../css/style-reg.css">
                <link rel="icon" type="image/x-icon" href="imgs/logo.png">
            </head>
            <section class="container">
                <h2>Welcome to SecondCharm!</h2>

                <?php if ($login) : ?>
                    <p class="account-p">Log in to continue</p>
                <?php else : ?>
                    <p class="sign-p">Sign up to continue</p>
                <?php endif; ?>

                <div class="error-popup" id="error-popup">
                    <?php 
                        if(isset($_SESSION['error'])) {
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        }
                    ?>
                </div>
                <?php 
                if ($login) drawLoginForm();
                else drawSignupForm();
                ?>
            </section>
            <script src="script.js"></script>
        </body>
    </html>
<?php } ?>

<?php function drawLoginForm() { ?>
    <form action="../actions/action_login.php" method="post">
        Email: <input type="text" name="email"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" name="submit" value="Continue">
    </form>
    <p>Don’t have an account? <a href="signup.php">Sign up</a>.</p>
<?php } ?>

<?php function drawSignupForm() { ?>
    <form action="../actions/action_sign_up.php" method="post">
        Your name: <input type="text" name="name"><br>
        Username: <input type="text" name="username"><br>
        Email: <input type="text" name="email"><br>
        Password: <input type="password" name="password"><br>
        Re-enter password: <input type="password" name="reenter_password"><br>
        <input type="submit" name="submit" value="Continue">
    </form>
    <p>Already have an account? <a href="login.php">Log in</a>.</p>
<?php } ?>

