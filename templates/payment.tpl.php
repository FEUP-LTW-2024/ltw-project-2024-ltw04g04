<?php declare(strict_types = 1); ?>

<?php function drawDelivery(PDO $db, Session $session) { ?>
        <body>
            <main>
            <div class="payContainer">
                <h1>Delivery</h1>
                <div class="payForm">
                    <div id="payAdress">
                        <button id="accountAdressButton" type="submit"> Use your account's adress </button>
                        <p> or </p>
                    </div>

                    <form method="POST">    
                        <div class="payDiv">
                            <label for="adress">Adress:</label>
                            <input type="text" id="adress" name="adress" required>
                        </div>
                        <div class="payDiv">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="payDiv">
                            <label for="country">Country:</label>
                            <input type="text" id="country" name="country" required>
                        </div>
                        <div class="payDiv">
                            <label for="postal-code">Postal Code:</label>
                            <input type="text" id="postal-code" name="postal-code" required>
                        </div>
                        <div class="payDiv">
                            <button id="otherAdressButton" type="submit"> Continue </button>
                        </div>

                    </form>
                </div>
            </div>
            </main>
        </body>
    
<?php } ?>


<?php function drawPayment(PDO $db, Session $session) { ?>
    <body>
        <main>
        <div class="payContainer">
            <h1>Payment</h1>
            <div class="payForm">
                <form action="action_process_payment.php" method="POST">    <!-- Criar action -->
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
                    <div id="payInfo">
                        <p> Value: </p>
                    </div>
                    <div class="payDiv">
                        <button type="submit"> Pay now </button>
                    </div>
                </form>
            </div>
        </div>
        </main>
    </body>
<?php } ?>