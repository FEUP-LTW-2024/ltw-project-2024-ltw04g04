<?php declare(strict_types = 1); ?>

<?php function drawPayment(PDO $db, Session $session) { ?>
        
    <body>
        <main>
        <div class="payContainer">
            <h1>Payment</h1>
            <form action="action_process_payment.php" method="POST">    <!-- Criar action -->


                <div class="payDiv">
                    <label for="card-number">Card Number:</label>
                    <input type="text" id="card-number" name="card-number" required>
                </div>
                <div class="payDiv">
                    <label for="expiry-date">Expiration Date :</label>
                    <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/AA" required>
                </div>
                <div class="payDiv">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required>
                </div>
                <div class="payDiv">
                    <button type="submit"> Pay now </button>
                </div>
            </form>
        </div>
        </main>
    </body>

<?php } ?>