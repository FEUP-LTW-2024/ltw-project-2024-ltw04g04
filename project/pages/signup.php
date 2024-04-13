<?php
    session_start();
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $reenterPassword = $_POST['reenter_password'];

        // TODO: Add your own registration logic here, including password matching and validation

        // If registration is successful
        if(true){ 
            $_SESSION['email'] = $email;
            header("Location: account.php"); 
        } else {
            echo "Registration failed";
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
        <div class="container">
            <h2>Welcome to SecondCharm!</h2>
            <p class="sign-p">Sign up to continue</p>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                Your name: <input type="text" name="name"><br>
                Email: <input type="text" name="email"><br>
                Password: <input type="password" name="password"><br>
                Re-enter password: <input type="password" name="reenter_password"><br>
                <input type="submit" name="submit" value="Continue">
            </form>

            <p>Already have an account? <a href="account.php">Log in</a>.</p>
        </div>
    </body>
</html>
