<?php
    session_start();
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        // TODO: Add your own authentication logic here

        // If authentication is successful
        if(true){ 
            $_SESSION['email'] = $email;
            header("Location: welcome.php"); 
        } else {
            echo "Invalid email or password";
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
            <p>Log in to continue</p>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                Email: <input type="text" name="email"><br>
                Password: <input type="password" name="password"><br>
                <input type="submit" name="submit" value="Continue">
            </form>

            <p>Don’t have an account? <a href="signup.php">Sign up</a>.</p>
        </div>
    </body>
</html>
