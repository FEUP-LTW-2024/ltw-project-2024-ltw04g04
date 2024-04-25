
<?php function drawUserPage(User $user, bool $editMode) { ?>
    <main>
        <section id="profile">
            <div id="avatar"><img src="imgs/avatar.png" alt="User Avatar"></div>
            <div id="userInfo">
                <h1><?= $user->name ?></h1>
                <form action="../actions/action_edit_profile.php" method="post" class="<?= $editMode ? 'editForm' : 'notEdit' ?>">
                    <h2>Profile</h2>
                    <?php if ($editMode) : ?>
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= $user->username ?>">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="<?= $user->name ?>">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="<?= $user->email ?>">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?= $user->city ?>" >
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="<?= $user->address ?>">
                        <label for="country">Country</label>
                        <input type="text" id="country" name="country" value="<?= $user->country ?>">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" id="postal_code" name="postal_code" value="<?= $user->postalCode ?>">
                        <button type="submit" id="editButton">Save</button>
                        
                    <?php else : ?>
                        <p><strong>Username:</strong> <?= $user->username ?></p>
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
<?php } ?>

<?php function drawShoppingCart() { ?>
        <main>
            <h1 id= "myCart" >My Shopping Cart</h1>
            <section id="shoppingCart">
                <section id="items">
                    
                </section>
                <section id="summary">
                    <h1>Order Summary</h1>
                    <p>Subtotal: 0.00$</p>
                    <button>Checkout</button>   
                </section>
            </section>
        </main>
    </body>
    </html>
<?php } ?>

<?php function drawFavourites() { ?>
        <main>
            <h1 id= "myFavs" >Wish List</h1>
                <section id="items">
                    
                </section>
        </main>
    </body>
    </html>
<?php } ?>