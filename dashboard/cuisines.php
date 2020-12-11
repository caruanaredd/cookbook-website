<?php
    include '../libraries/view.php';

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
<div class="alert alert-secondary text-center">There are no registered cuisines.</div>

<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th scope="col" style="width: 10%">#</th>
            <th scope="col" style="width: 60%">Cuisine</th>
            <th scope="col" style="width: 30%"></th>
        </tr>
    </thead>

    <tbody>
        <th scope="row">1</th>
        <td>Italian</td>
        <td class="text-right">
            <a href="#" class="btn btn-sm btn-primary">Edit</a>
            <a href="#" class="btn btn-sm btn-danger">Delete</a>
        </td>
    </tbody>
</table>
<?= endSection(); ?>

<!-- Prints the complete layout -->
<?= output(); ?>