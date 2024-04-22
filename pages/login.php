<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
?>


<!DOCTYPE html>
<html>
    <body>
        <head>
            <link rel="stylesheet" type="text/css" href="style-reg.css">
            <link rel="icon" type="image/x-icon" href="imgs/logo.png">
        </head>
        <section class="container">
            <h2>Welcome to SecondCharm!</h2>
            <p class="account-p">Log in to continue</p>

            <div class="error-popup" id="error-popup">
                <?php 
                    if(isset($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                ?>
            </div>

            <form action="../actions/action_login.php" method="post">
                Email: <input type="text" name="email"><br>
                Password: <input type="password" name="password"><br>
                <input type="submit" name="submit" value="Continue">
            </form>

            <p>Don’t have an account? <a href="signup.php">Sign up</a>.</p>
        </section>
        <script src="script.js"></script>
    </body>
</html>
