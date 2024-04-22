<!DOCTYPE html>
<html>
<?php 
    include 'navigation.php'; 
    
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../actions/actions.php');

    $session = new Session();
    $categories = getCategories();
    generateNavigationMenu($session, $categories);
?>
    <main>
        <h1 id= "myFavs" >Wish List</h1>
            <section id="items">
                   
            </section>
    </main>
</body>
</html>