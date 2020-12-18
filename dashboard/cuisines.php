<?php
    include '../libraries/view.php';
    include '../libraries/database.php';

    // retrieve the information from the database.
    $cuisines = getAllCuisines();

    // creating a variable that will control the numbering of our list.
    $count = 0;

    // tell php to extend a layout
    extend('template.php');
?>

<!-- Page Title -->
<?= startSection('title'); ?>
Cuisines
<?= endSection(); ?>

<!-- Action Button -->
<?= startSection('action button'); ?>
<a href="cuisine-add.php" class="btn btn-primary">Add Button</a>
<?= endSection(); ?>

<!-- Content -->
<?= startSection('content'); ?>
<?php if ($cuisines == false or mysqli_num_rows($cuisines) == 0): ?>
    <div class="alert alert-secondary text-center">There are no registered cuisines.</div>
<?php else: ?>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 10%">#</th>
                <th scope="col" style="width: 60%">Cuisine</th>
                <th scope="col" style="width: 30%"></th>
            </tr>
        </thead>

        <tbody>
<?php while ($cuisine = mysqli_fetch_assoc($cuisines)): $count++; ?>
            <tr>
                <th scope="row"><?= $count ?></th>
                <td><?= $cuisine['name'] ?></td>
                <td class="text-right">
                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                    <a href="cuisine-delete.php?id=<?= $cuisine['cuisineID']; ?>" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
<?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>
<?= endSection(); ?>

<!-- Prints the complete layout -->
<?= output(); ?>