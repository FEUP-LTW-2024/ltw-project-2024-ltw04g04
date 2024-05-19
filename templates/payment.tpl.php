<?php 
declare(strict_types = 1); 
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/ShoppingCart.class.php');
require_once(__DIR__ . '/../database/item.class.php');
?>

<?php
function drawPayment(PDO $db, Session $session) {
    ?>
    <script src="../javascript/payment.js"></script>
    <body>
        <?php
            if ($session->isLogin()) {
                $userId = $session->getUserId();
                $cond = User::adressIsComplete($db, $userId);
                echo "<script> accountAdressComplete = $cond; </script>";
                $subTotal = shoppingCart::calculateCartTotal($db, $userId);
            }
        ?>
        <main>
            <div class="payContainer">
                <h1>Payment</h1>
                <div id="payInfo">
                    <p>Subtotal: <?= $subTotal ?> $ </p>
                </div>

                <h2 class="subtitlePayment">Delivery</h2>
                <div id="payAdress">
                    <button id="toggleAdressButton" class="toggle-button">Use your account's address</button>
                    <p>or</p>
                </div>

                <form id="paymentForm" action="../actions/action_process_payment.php" method="POST" onsubmit="return validatePaymentForm()">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">

                    <!-- Delivery Address -->
                    <div class="payDiv">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address">
                    </div>
                    <div class="payDiv">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city">
                    </div>
                    <div class="payDiv">
                        <label for="country">Country:</label>
                        <input type="text" id="country" name="country">
                    </div>
                    <div class="payDiv">
                        <label for="postal-code">Postal Code:</label>
                        <input type="text" id="postal-code" name="postal-code">
                    </div>

                    <h2 class="subtitlePayment">Payment Method</h2>
                    <div class="payDiv">
                        <label for="card-number">Card Number:</label>
                        <input type="text" id="card-number" name="card-number" required>
                    </div>
                    <div class="payDiv">
                        <label for="expiration-date">Expiration Date (MM/YY):</label>
                        <input type="text" id="expiration-date" name="expiration-date" placeholder="MM/YY" required>
                    </div>
                    <div class="payDiv">
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" required>
                    </div>

                    <div class="payDiv">
                        <button type="submit">Submit payment</button>
                    </div>
                </form>
            </div>
        </main>
    </body>
    <?php
}
?>
