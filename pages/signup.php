<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../actions/actions.php');
 
    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $reenterPassword = $_POST['reenter_password'];
        $error = signUp($username, $name, $email, $password, $reenterPassword);
    
        // If registration is successful
        if($error == '') { 
            header("Location: account.php");
            exit();  
        } else {
            $_SESSION['error'] = $error;
        }
    }
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
            <p class="sign-p">Sign up to continue</p>

            <div class="error-popup" id="error-popup">
                <?php 
                    if(isset($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                ?>
            </div>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                Your name: <input type="text" name="name"><br>
                Username: <input type="text" name="username"><br>
                Email: <input type="text" name="email"><br>
                Password: <input type="password" name="password"><br>
                Re-enter password: <input type="password" name="reenter_password"><br>
                <input type="submit" name="submit" value="Continue">
            </form>
            <p>Already have an account? <a href="account.php">Log in</a>.</p>
        </section>
        <script src="script.js"></script>
    </body>
</html>
