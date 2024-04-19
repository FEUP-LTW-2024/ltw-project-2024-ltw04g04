<?php
    session_start();
    require_once(__DIR__ . '/../actions/actions.php');

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $db = getDatabaseConnection();
            $stmt = $db->prepare("SELECT * FROM User WHERE Email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) { 
                $_SESSION['email'] = $email;
                header("Location: welcome.php"); 
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
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
            <p class="account-p">Log in to continue</p>

            <div class="error-popup" id="error-popup">
                <?php 
                    if(isset($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                ?>
            </div>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                Email: <input type="text" name="email"><br>
                Password: <input type="password" name="password"><br>
                <input type="submit" name="submit" value="Continue">
            </form>

            <p>Don’t have an account? <a href="signup.php">Sign up</a>.</p>
        </section>
        <script src="script.js"></script>
    </body>
</html>
