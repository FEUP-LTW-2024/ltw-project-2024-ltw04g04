<?php declare(strict_types = 1); ?>

<?php function drawPayment(PDO $db, Session $session) { ?>
    <script src="../templates/payment.js"></script>
    <body>
        <main>
            <div class="payContainer">
                <h1>Payment</h1>
                <div id="payInfo">
                        <p> Value: </p>
                </div>

                <h2 class="subtitlePayment"> Delivery </h2>
                <div id="payAdress">
                    <?php ?>
                    <button id="toggleAdressButton" class="toggle-button"> Use your account's adress </button>
                    <p> or </p>
                </div>

                <form action="action_process_payment.php" method="POST" onsubmit="return validatePaymentForm()">    <!-- Criar action -->    
                    <div class="payDiv">
                        <label for="adress">Adress:</label>
                        <input type="text" id="adress" name="adress">
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

                    <h2 class="subtitlePayment"> Payment Method </h2>
                    <div class="payDiv">
                        <label for="card-number">Card Number:</label>
                        <input type="text" id="card-number" name="card-number" required>
                    </div>
                    <div class="payDiv">
                        <label for="expiration-date">Expiration Date:</label>
                        <input type="text" id="expiration-date" name="expiration-date" placeholder="MM/AA" required>
                    </div>
                    <div class="payDiv">
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" required>
                    </div>
                    <div class="payDiv">
                        <button type="submit"> Submit payment </button>
                    </div>
                </form>

            </div>
        </main>
    </body>
    
<?php } ?>