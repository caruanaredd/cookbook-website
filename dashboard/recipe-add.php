<?php
    include '../libraries/database.php';
    include '../libraries/file.php';
    include '../libraries/form.php';
    include '../libraries/view.php';

    // Predefined tables for the dropdown menus.
    $cuisines = getAllCuisines();
    $levels = getAllLevels();

    // TODO: Check if there was a post request.

    // The input values from the form.
    $title          = getPostData('title');
    $description    = getPostData('description');
    $prepTime       = getPostData('prep-time');
    $cookTime       = getPostData('cook-time');
    $additionalTime = getPostData('additional-time');
    $yields         = getPostData('yields');
    $levelID        = getPostData('level-id');
    $cuisineID      = getPostData('cuisine-id');

    // TODO: Check that the user has sent valid information.

    // Handle the file upload.
    $image          = getFileData('image');
    
    if ($image && $image['name'] != '')
    {
        if (!isImage($image))
        {
            $formErrors['image'] = 'Please upload an image file.';
            $errors = true;
        }
    }

    // If there are no errors, process the information normally.
    if (!$errors)
    {
        // Add the recipe to the database and retrieve its primary key.
        $idCheck = addRecipe($title, $description, $prepTime, $cookTime, $additionalTime, $yields, $levelID, $cuisineID);

        // If the insert ID is greater than zero, there were no errors.
        if ($idCheck > 0)
        {
            $uploadCheck = uploadFile($image, '../uploads/recipes', $idCheck);
            if (!$uploadCheck)
            {
                $formErrors['image'] = 'Image could not be uploaded at this time.';
                $errors = true;
            }
        }

        // if (!$errors)
        // {
        //     header('Location:recipes.php');
        //     return;
        // }
    }


    extend('template.php');
?>

<?= startSection('title'); ?>
Add Recipe
<?= endSection(); ?>

<?= startSection('content'); ?>
    <div class="alert alert-danger text-center mb-3">This record could not be added to the database.</div>

    <form action="recipe-add.php" method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="input-title" class="col-md-2 col-form-label">Title</label>
            <div class="col-md-10">
                <input type="text" name="title" id="input-title" class="form-control" placeholder="Title" value="">

                <small class="d-block text-danger mt-1">Error</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="input-image" class="col-md-2 col-form-label">Image</label>
            <div class="col-md-10">
                <div class="custom-file">
                    <input type="file" name="image" id="input-image" class="custom-file-input">
                    <label for="input-image" class="custom-file-label">Choose file...</label>
                </div>
                <small class="d-block text-danger mt-1">Error</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="input-description" class="col-md-2 col-form-label">Description</label>
            <div class="col-md-10">
                <textarea class="form-control" name="description" id="input-description" cols="30" rows="10" placeholder="Recipe Description"></textarea>
                <small class="d-block text-danger mt-1">Error</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="input-prep-time" class="col-md-2 col-form-label">Prep Time</label>
            <div class="col-md-10">
                <input type="number" name="prep-time" id="input-prep-time" class="form-control" placeholder="30" min="0" max="360" step="1" value="">
                <small class="d-block text-danger mt-1">Error</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="input-cook-time" class="col-md-2 col-form-label">Cook Time</label>
            <div class="col-md-10">
                <input type="number" name="cook-time" id="input-cook-time" class="form-control" placeholder="30" min="0" max="360" step="1" value="">
                <small class="d-block text-danger mt-1">Error</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="input-additional-time" class="col-md-2 col-form-label">Additional</label>
            <div class="col-md-10">
                <input type="number" name="additional-time" id="input-additional-time" class="form-control" placeholder="30" min="0" max="360" step="1" value="">
                <small class="d-block text-danger mt-1">Error</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="input-yields" class="col-md-2 col-form-label">Yields</label>
            <div class="col-md-10">
                <input type="number" name="yields" id="input-yields" class="form-control" placeholder="2" min="0" max="400" step="1" value="">
                <small class="d-block text-danger mt-1">Error</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="input-level" class="col-md-2 col-form-label">Level</label>
            <div class="col-md-10">
                <select name="level-id" id="input-level" class="custom-select">
                    <option disabled selected>Please choose a level.</option>
<?php while ($level = mysqli_fetch_assoc($levels)): ?>
                    <option value="<?= $level['levelID']; ?>"><?= $level['name']; ?></option>
<?php endwhile; ?>
                </select>
                <small class="d-block text-danger mt-1">Error</small>
            </div>
        </div>

        <div class="form-group row">
            <label for="input-cuisine" class="col-md-2 col-form-label">Cuisine</label>
            <div class="col-md-10">
                <select name="cuisine-id" id="input-cuisine" class="custom-select">
                    <option disabled selected>Please choose a cuisine.</option>
<?php while ($cuisine = mysqli_fetch_assoc($cuisines)): ?>
                    <option value="<?= $cuisine['cuisineID']; ?>"><?= $cuisine['name']; ?></option>
<?php endwhile; ?>
                </select>
                <small class="d-block text-danger mt-1">Error</small>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <button type="submit" class="d-block ml-auto btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>
<?= endSection(); ?>

<?= output(); ?>