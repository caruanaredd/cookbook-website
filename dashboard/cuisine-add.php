<?php
    include '../libraries/database.php';
    include '../libraries/form.php';
    include '../libraries/view.php';

    // Storage for the errors.
    $formErrors = [];

    // Process the form if it was submitted.
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $errors = false;
        
        $name = getPostData('name');
        if (isEmpty($name))
        {
            $formErrors['name'] = "Please enter a name.";
            $errors = true;
        }
        else if (!minLength($name, 3))
        {
            $formErrors['name'] = "Please enter at least 3 characters.";
            $errors = true;
        }

        // If no errors were encountered, redirect the user
        // and stop all processing of this page.
        if (!$errors)
        {
            // Get the next primary key from the table insertion.
            $idCheck = addCuisine($name);

            // Only redirect if the primary key is 1 and above.
            if ($idCheck > 0)
            {
                header('Location:cuisines.php');
                return;
            }

            $formErrors['database'] = true;
        }
    }

    extend('template.php');
?>

<?= startSection('title'); ?>
Add Cuisine
<?= endSection(); ?>

<?= startSection('content'); ?>
<?php if (isset($formErrors['database'])): ?>
    <div class="alert alert-danger text-center mb-3">This record could not be added.</div>
<?php endif; ?>

<form action="cuisine-add.php" method="post">
    <div class="form-group row">
        <label for="input-name" class="col-md-2 col-form-label">Name</label>
        <div class="col-md-10">
            <input type="text" name="name" id="input-name" class="form-control" placeholder="Name" value="<?= getPostData('name'); ?>">

<?php if (isset($formErrors['name'])): ?>
            <small class="d-block mt-1 text-danger"><?= $formErrors['name']; ?></small>
<?php endif; ?>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-12">
            <button type="submit" class="d-block ml-auto btn btn-primary">Submit</button>
        </div>
    </div>
</form>
<?= endSection(); ?>

<?= output(); ?>