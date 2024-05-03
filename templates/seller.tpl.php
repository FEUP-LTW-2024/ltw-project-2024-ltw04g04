
<?php function drawUserProfile(User $user, bool $isCurrentUser) { ?>
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
    </main>
<?php } ?>
