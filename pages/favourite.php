<!DOCTYPE html>
<html>
<?php 
include 'navigation.php'; 
require_once(__DIR__ . '/../actions/actions.php');
$categories = getCategories();
generateNavigationMenu($categories);
 ?>
    <main>
        <h1 id= "myFavs" >Wish List</h1>
            <section id="items">
                   
            </section>
    </main>
</body>
</html>