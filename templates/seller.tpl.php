<?php 
    include_once 'account.tpl.php'; 
    require_once(__DIR__ . '/../database/item.class.php');
?>


<?php function drawSellerProfile(Session $session, PDO $pdo, User $user, bool $isCurrentUser) { 
    $items = Item::getUserItemIds($pdo, $user->userId);
    ?>
    <main>
        <section id="profile">
            <div id="avatar"><img src="imgs/avatar.png" alt="User Avatar"></div>
            <div id="userInfo">
                <h1><?= $user->name ?> 
                <?php if ($user->isAdmin) : ?>
                    <img src="/../pages/imgs/verified-icon.png" alt="Verified" id="verified" class="verified"></br>
                    <span class="admin-text">Administrator</span>
                <?php endif; ?>
                <?php if ($session->isAdmin()) : ?>
                    <?php if ($user->isAdmin) : ?>
                        <form action="../actions/action_make_admin.php" method="post">
                            <input type="hidden" name="user_id" value="<?= $user->userId ?>">
                            <input type="hidden" name="action" value="remove_admin">
                            <input type="submit" name="remove_admin" value="Remove Admin" class="remove-admin">
                        </form>
                    <?php else : ?>
                        <form action="../actions/action_make_admin.php" method="post">
                            <input type="hidden" name="user_id" value="<?= $user->userId ?>">
                            <input type="hidden" name="action" value="make_admin">
                            <input type="submit" name="make_admin" value="Make Admin" class="make-admin">
                        </form>
                    <?php endif; ?>
                <?php endif; ?>

                </h1>
                <p><strong>Username:</strong> <?= $user->username ?></p>
                <p><strong>Email:</strong> <?= $user->email ?></p>
                <p><strong>City:</strong> <?= $user->city ?></p>
                <p><strong>Country:</strong> <?= $user->country ?></p>
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
                        <?php $item =Item::getItemWithId($pdo, $i); ?>
                        <article class="articleItem<?= ($index % 3 == 2) ? ' lastInRow' : '' ?>">
                            <a href="item.php?id=<?= $item->itemId ?>">
                                <img src="<?= $item->imageLink ?>" class="articleImage" alt="Item Image">
                            </a>
                            <h3><?= $item->name ?></h3>
                            <p><?= $item->price ?> $</p>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <h2>No Items for Sale</h2>
                <p id = "noItems">This user currently has no items for sale.</p>
            <?php endif; ?>
        </section>
    </main>
<?php } ?>
