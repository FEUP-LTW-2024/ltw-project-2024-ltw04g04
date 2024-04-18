<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/connectDB.php');
    try {
        $db = getDatabaseConnection();
        //echo "Connecting to database successfull!";
    } catch (PDOException $e) {
        echo "Error connecting to database: " . $e->getMessage();
    }

    require_once(__DIR__ . '/../database/user.class.php');
    session_start();
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $reenterPassword = $_POST['reenter_password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // INVALID EMAIL
        } else if (strlen($password) < 5) {
            // INVALID PASSWORD - 5 chars min
        } else if ($password !== $reenterPassword) {
            // INVALID REENTER PASSWORD
        } else {
            // VALID -> REGISTER
            User::registerUser($db, $name, $email, $password);
        }
        
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
        <section class="container">
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
        </section>
    </body>
</html>
