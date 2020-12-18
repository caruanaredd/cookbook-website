<?php
    include '../libraries/database.php';
    include '../libraries/view.php';

    // First, get the cuisine ID and check that it exists.
    $cuisineID = $_GET['id'];
    $cuisine = getCuisine($cuisineID);

    if ($cuisine !== false)
    {
        // delete the cuisine.
        if (deleteCuisine($cuisineID))
        {
            header("Location:cuisines.php");
            exit;
        }
    }

    extend('template.php');
?>

<?= startSection('title'); ?>
Delete Cuisine
<?= endSection(); ?>

<?= startSection('content'); ?>
    <div class="alert alert-danger text-center">This cuisine does not exist.</div>
<?= endSection(); ?>

<?= output(); ?>