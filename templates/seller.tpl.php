<?php 
include_once 'account.tpl.php'; ?>

<?php function drawSellerProfile(PDO $pdo, User $user, bool $isCurrentUser) { 
    $items = getUserItems($pdo, $user->userId);
    ?>
    <main>
        <section id="profile">
            <div id="avatar"><img src="imgs/avatar.png" alt="User Avatar"></div>
            <div id="userInfo">
                <h1><?= $user->name ?></h1>
                <p><strong>Username:</strong> <?= $user->username ?></p>
                <p><strong>Email:</strong> <?= $user->email ?></p>
                <p><strong>City:</strong> <?= $user->city ?></p>
                <p><strong>Country:</strong> <?= $user->country ?></p>
                <?php if ($isCurrentUser) : ?>
                    <a href="account.php?edit" id="editButton">Edit</a>
                <?php endif; ?>
            </div>
        </section>

        <section id="items">
            <?php if (count($items) > 0) : ?>
                <h2>Items for Sale</h2>
                <div class="itemGrid">
                    <?php foreach ($items as $index => $item) : ?>
                        <article class="articleItem<?= ($index % 3 == 2) ? ' lastInRow' : '' ?>">
                            <img src="<?= $item->imageLink ?>" class="articleImage" alt="Item Image">
                            <h3><?= $item->name ?></h3>
                            <p>Price: <?= $item->price ?> $</p>
                            <a href="item.php?id=<?= $item->itemId ?>">View Item</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <h2>No Items for Sale</h2>
                <p>This user currently has no items for sale.</p>
            <?php endif; ?>
        </section>
    </main>
<?php } ?>
