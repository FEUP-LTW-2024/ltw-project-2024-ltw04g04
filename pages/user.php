<!DOCTYPE html>
<html>
<?php 
    include 'navigation.php'; 

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../actions/actions.php');

    $session = new Session();

    if (!$session->isLogin()) die(header('Location: /'));

    $db = getDatabaseConnection();
    $user = User::getUserWithId($db, $session->getUserId());
    $editMode = isset($_GET['edit']);

    $categories = getCategories();
    generateNavigationMenu($session,$categories);
?>
<main>
    <section id="profile">
        <div id="avatar"><img src="imgs/avatar.png" alt="User Avatar"></div>
        <div id="userInfo">
            <h1><?= $user->name ?></h1>
            <form action="../actions/action_edit_profile.php" method="post" class="<?= $editMode ? 'editForm' : 'notEdit' ?>">
                <h2>Profile</h2>
                <?php if ($editMode) : ?>
                    <label for="userName">Username</label>
                    <input type="text" id="userName_" name="userName_" value="<?= $user->userName ?>">
                    <label for="name">Name</label>
                    <input type="text" id="name_" name="name_" value="<?= $user->name ?>">
                    <label for="email">E-mail</label>
                    <input type="email" id="email_" name="email_" value="<?= $user->email ?>">
                    <label for="city">City</label>
                    <input type="text" id="city_" name="city_" value="<?= $user->city ?>" >
                    <label for="address">Address</label>
                    <input type="text" id="address_" name="address_" value="<?= $user->address ?>">
                    <label for="country">Country</label>
                    <input type="text" id="country_" name="country_" value="<?= $user->country ?>">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" id="postal_code_" name="postal_code_" value="<?= $user->postalCode ?>">
                    <button type="submit" id="editButton">Save</button>
                <?php else : ?>
                    <p><strong>Username:</strong> <?= $user->userName ?></p>
                    <p><strong>Name:</strong> <?= $user->name ?></p>
                    <p><strong>Email:</strong> <?= $user->email ?></p>
                    <p><strong>City:</strong> <?= $user->city ?></p>
                    <p><strong>Address:</strong> <?= $user->address ?></p>
                    <p><strong>Country:</strong> <?= $user->country ?></p>
                    <p><strong>Postal Code:</strong> <?= $user->postalCode ?></p>
                    <a href="?edit" id="editButton">Edit</a>
                <?php endif; ?>

            </form>
        </div>
    </section>
    <!-- Articles Section -->
    <section id="articles">
        <!-- Article 1 -->
        <article class="articleItem">
            <!-- Image of article 1 -->
            <!-- Replace 'article1.jpg' with the actual path of your image -->
            <img src="imgs/article1.jpg" class="articleImage" alt="Article 1 Image">
            <!-- Description of article 1-->
            <!-- <p> Description about this article.</p> -->
        </article>
        <!-- Add more articles as necessary -->
    </section>
</main>
</body>
</html>

