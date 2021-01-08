<?php
    include '../libraries/database.php';
    include '../libraries/view.php';
    
    extend('template.php');
?>

<?= startSection('title'); ?>
Recipe List
<?= endSection(); ?>

<?= startSection('action button'); ?>
<a href="recipe-add.php" class="btn btn-primary">Add</a>
<?= endSection(); ?>

<?= startSection('content'); ?>
    <div class="alert alert-secondary text-center">There are no registered recipes.</div>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 5%">#</th>
                <th scope="col" style="width: 50%">Title</th>
                <th scope="col" style="width: 15%">Cuisine</th>
                <th scope="col" style="width: 15%">Level</th>
                <th scope="col" style="width: 15%"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Recipe Name</td>
                <td>Cuisine</td>
                <td>Level</td>
                <td class="text-right">
                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
<?= endSection(); ?>

<?= output(); ?>