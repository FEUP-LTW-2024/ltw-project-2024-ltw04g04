<?php 
    include_once 'account.tpl.php'; 
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/user.class.php');
?>


<?php
function drawSellerProfile(Session $session, PDO $pdo, User $user, bool $isCurrentUser) { 
    $items = Item::getUserItemIds($pdo, $user->userId);
    $averageRating = User::getSellerAverageRating($pdo, $user->userId);
    ?>
    
    <section id="profile">
        <div id="avatar"><img src="imgs/avatar.png" alt="User Avatar"></div>
        <div id="userInfo">
            <div id="userHeader">
                <h1><?= htmlspecialchars($user->name) ?></h1>
                <?php if (!$isCurrentUser && $session->isLogin()) : ?>
                    <form action="../pages/chat.php" method="post">
                        <input type="hidden" name="chatId" value="<?= htmlspecialchars($user->userId) ?>">
                        <button id="newChatButton" type="submit"> Send message </button>
                    </form>
                <?php endif; ?>
            </div>

            <?php if ($user->isAdmin) : ?>
                <img src="/../pages/imgs/verified-icon.png" alt="Verified" id="verified" class="verified"><br>
                <span class="admin-text">Administrator</span>
            <?php endif; ?>
            <?php if ($session->isAdmin()) : ?>
                <?php if ($user->isAdmin) : ?>
                    <form action="../actions/action_make_admin.php" method="post">
                        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user->userId) ?>">
                        <input type="hidden" name="action" value="remove_admin">
                        <input type="submit" name="remove_admin" value="Remove Admin" class="remove-admin">
                    </form>
                <?php else : ?>
                    <form action="../actions/action_make_admin.php" method="post">
                        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user->userId) ?>">
                        <input type="hidden" name="action" value="make_admin">
                        <input type="submit" name="make_admin" value="Make Admin" class="make-admin">
                    </form>
                <?php endif; ?>
            <?php endif; ?>

            <p><strong>Username:</strong> <?= htmlspecialchars($user->username) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($user->city) ?></p>
            <p><strong>Country:</strong> <?= htmlspecialchars($user->country) ?></p>
            <p><strong>Average Rating:</strong> <?= htmlspecialchars($averageRating) ?> / 5</p>
            <?php if (!$isCurrentUser && $session->isLogin()) : ?>
                <form action="../actions/action_rating.php" method="post">
                    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <input type="hidden" name="seller_id" value="<?= htmlspecialchars($user->userId) ?>">
                    <label for="rating">Rate this seller:</label>
                    <select name="rating" id="rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <input type="submit" value="Submit Rating">
                </form>
            <?php endif; ?>
            <?php if ($isCurrentUser) : ?>
                <a href="account.php?edit" id="editButton">Edit</a>
            <?php endif; ?>
        </div>
    </section>

    <section id="sellerItems">
        <?php if (count($items) > 0) : ?>
            <h2>Items for Sale</h2>
            <div class="itemGrid">
                <?php foreach ($items as $index => $i) : ?>
                    <?php $item = Item::getItemWithId($pdo, $i); ?>
                    <article class="articleItem<?= ($index % 3 == 2) ? ' lastInRow' : '' ?>">
                        <a href="item.php?id=<?= htmlspecialchars($item->itemId) ?>">
                            <img src="<?= htmlspecialchars($item->imageLink) ?>" class="articleImage" alt="Item Image">
                        </a>
                        <h3><?= htmlspecialchars($item->name) ?></h3>
                        <p><?= htmlspecialchars($item->price) ?> $</p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <h2>No Items for Sale</h2>
            <p id="noItems">This user currently has no items for sale.</p>
        <?php endif; ?>
    </section>
<?php
}
