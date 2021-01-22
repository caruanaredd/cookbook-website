<?php
    include 'libraries/database.php';
    include 'libraries/file.php';

    $recipes = getAllRecipes();

    while ($recipe = mysqli_fetch_assoc($recipes)):
?>
    <div>
        <img src="<?= getImage("uploads/recipes/{$recipe['recipeID']}"); ?>" alt="">
        <?= $recipe['title']; ?>
    </div>
<? endwhile; ?>