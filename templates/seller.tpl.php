<?php 
    include_once 'account.tpl.php'; 
    require_once(__DIR__ . '/../database/item.class.php');
?>


<?php function drawSellerProfile(Session $session, PDO $pdo, User $user, bool $isCurrentUser) { 
    $items = Item::getUserItemIds($pdo, $user->userId);
    ?>
    
        <section id="profile">
                <div id="userHeader">
                    <img id="avatar" src="<?= $user->profileImage ?>" alt="User Profile Image">
                    <h1><?= $user->name ?> 
                        <?php if ($user->isAdmin) : ?>
                            <div class="admin-info">
                            <img src="/../pages/imgs/verified-icon.png" alt="Verified" id="verified" class="verified">
                            <span class="admin-text">Administrator </span>
                            </div>
                        <?php endif; ?>
                    </h1>
                    <?php if (!$isCurrentUser && $session->isLogin()) : ?>
                        <form action="../pages/chat.php" method="post">
                            <input type="hidden" name="chatId" value="<?= $user->userId ?> ">
                            <button id="newChatButton" type="submit"> Send message </button>
                        </form>
                    <?php endif; ?>
                </div>

                <div id="sellerInfo">
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
