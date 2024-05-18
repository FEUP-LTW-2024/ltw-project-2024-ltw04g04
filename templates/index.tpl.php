<?php 
    declare(strict_types = 1); 
    require_once(__DIR__ . '/../database/user.class.php');
?>

<?php function drawWelcomePage() { ?>
    <main>
        <img id="jewels" src="imgs/jewels.jpg" alt="Jewelry">
        <section class = "customize">
            <p><br>SecondCharm to your liking with a touch of elegance.</br> Follow your favorite brands and discover the items that match your style.</p>
            <a href="account.php"><button>Customize</button></a>
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
                        <p>Name: <?= htmlspecialchars($user->name) ?></p>
                        <p>Username: <?= htmlspecialchars($user->username) ?></p>
                        <div class="rating-container-top">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <div class="star <?= $i <= $averageRating ? 'filled' : '' ?>"></div>
                            <?php endfor; ?>
                        </div>
                        <a href="../pages/seller.php?id=<?= $user->userId ?>" class="profile-button">Profile</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
<?php
}
?>


