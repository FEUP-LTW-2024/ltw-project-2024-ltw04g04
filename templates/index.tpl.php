<?php 
    declare(strict_types = 1); 
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/item.class.php');
?>

<?php function drawWelcomePage() { ?>
    <main>
        <img id="jewels" src="imgs/jewels.jpg" alt="Jewelry">
        <section class = "customize">
            <p>SecondCharm to your liking with a touch of elegance.</p>
            <p> Follow your favorite brands and discover the items that match your style. </p>
        </section>
    </main>
</body>
</html>
<?php } ?>

<?php
function topSellers(PDO $pdo) {
    $users = User::getTopSellers($pdo, 5);
?>
    <main>
        <h2 class="usersList">Top 5 Sellers</h2>
        <div class="users-container">
            <?php foreach ($users as $seller): 
                $user = User::getUserWithId($pdo, $seller['SellerId']); 
                $averageRating = (int) User::getSellerAverageRating($pdo, $user->userId);
            ?>
                <div class="seller">
                    <img src="../pages/imgs/user-icon.png" alt="User Icon">
                    <div class="user-details">
                        <p><?= htmlspecialchars($user->name) ?></p>
                        <p>@<?= htmlspecialchars($user->username) ?></p>
                        <div class="rating-container-top">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <div class="star <?= $i <= $averageRating ? 'filled' : '' ?>"></div>
                            <?php endfor; ?>
                        </div>
                        <form id="toSellerPage" action="../actions/action_process_seller.php" method="post">
                            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            <input type="hidden" name="seller-id" value="<?= $user->userId ?>">
                            <button id="profile-button" type="submit">Profile</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
<?php
}
?>

<?php
function displayRandomItems(PDO $pdo) {
    $items = Item::getRandomItems($pdo);
    $firstHalf = array_slice($items, 0, 5);
    $secondHalf = array_slice($items, 5, 9);
?>
    <script defer src="../javascript/itemRedirect.js"></script>
    <main>
        <h2 class="itemsList">Recomendations</h2>
        <div class="scroll-container">
            <div class="scroll-wrapper">
                <?php foreach ($firstHalf as $item): ?>
                    <div class="item" onclick="redirectToItemPage(<?php echo $item->itemId; ?>, '<?php echo $_SESSION['csrf']; ?>')">
                        <img src="<?= $item->imageLink ?>" alt="Item Image">
                        <div class="item-details">
                            <p><?= $item->name ?></p>
                            <p>Price: <?= $item->price ?></p>
                            <p>Brand: <?= $item->brand ?></p>
                            <p>Model: <?= $item->model ?></p>
                            <p>Condition: <?= $item->condition ?></p>
                            <p>Category: <?= $item->category ?></p>
                            <p>Stock: <?= $item->stock ?></p>
                            <p>Size: <?= $item->size ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="scroll-container">
            <div class="scroll-wrapper">
                <?php foreach ($secondHalf as $item): ?>
                    <div class="item" onclick="redirectToItemPage(<?php echo $item->itemId; ?>, '<?php echo $_SESSION['csrf']; ?>')">
                        <img src="<?= $item->imageLink ?>" alt="Item Image">
                        <div class="item-details">
                            <p><?= $item->name ?></p>
                            <p>Price: <?= $item->price ?></p>
                            <p>Brand: <?= $item->brand ?></p>
                            <p>Model: <?= $item->model ?></p>
                            <p>Condition: <?= $item->condition ?></p>
                            <p>Category: <?= $item->category ?></p>
                            <p>Stock: <?= $item->stock ?></p>
                            <p>Size: <?= $item->size ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
<?php
}
?>



