<?php
    include '../libraries/database.php';
    include '../libraries/form.php';
    include '../libraries/view.php';

    // First, get the cuisine ID and check that it exists.
    $cuisineID = $_GET['id'];
    $cuisine = getCuisine($cuisineID);

    // Storage for the errors.
    $formErrors = [];

    // Process the form if it was submitted.
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // Check that the cuisine ID from $_GET matches the hidden input.
        $hiddenCuisineID = getPostData('cuisine-id');
        if ($cuisineID == $hiddenCuisineID)
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
                // Update the record in the database.
                $check = editCuisine($cuisineID, $name);
    
                // Only redirect if the primary key is 1 and above.
                if ($check != false)
                {
                    header('Location:cuisines.php');
                    return;
                }
    
                $formErrors['database'] = true;
            }
        }
    }

    extend('template.php');
?>

<?= startSection('title'); ?>
Edit Cuisine: <?= !$cuisine ? 'Error' : $cuisine['name']; ?>
<?= endSection(); ?>

<?php if ($cuisine != false): ?>

<?= startSection('content'); ?>
<?php if (isset($formErrors['database'])): ?>
    <div class="alert alert-danger text-center mb-3">This record could not be added.</div>
<?php endif; ?>

<form action="cuisine-edit.php?id=<?= $cuisineID; ?>" method="post">
    <div class="form-group row">
        <label for="input-name" class="col-md-2 col-form-label">Name</label>
        <div class="col-md-10">
            <input type="text" name="name" id="input-name" class="form-control" placeholder="Name" value="<?= getPostData('name') ?: $cuisine['name']; ?>">

<?php if (isset($formErrors['name'])): ?>
            <small class="d-block mt-1 text-danger"><?= $formErrors['name']; ?></small>
<?php endif; ?>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-12">
            <input type="hidden" name="cuisine-id" value="<?= $cuisineID; ?>">
            <button type="submit" class="d-block ml-auto btn btn-primary">Submit</button>
        </div>
    </div>
</form>
<?= endSection(); ?>

<?php else: ?>

<?= startSection('content'); ?>
    <div class="alert alert-danger text-center">This cuisine does not exist.</div>
<?= endSection(); ?>

<?php endif; ?>

<?= output(); ?>