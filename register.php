<?php
    include 'libraries/database.php';
    include 'libraries/form.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // Process the registration form.
        $name           = getPostData('name');
        $surname        = getPostData('surname');
        $username       = getPostData('username');
        $email          = getPostData('email');
        $password       = getPostData('password');
        $passwordAgain  = getPostData('password-again');

        // Insert conditions checking validity here.

        // Check if username/email already exist in the database.

        // Try to register the user in the database.
        $userID = registerUser($username, $email, $password, 16);

        // If the user could not be registered, stop the process here.
        if (!$userID)
        {
            die('The user could not be registered due to a problem in the database.');
        }

        // Insert the meta information (name, surname) in the other table.
        registerUserMeta($userID, $name, $surname);

        // If nothing failed, redirect to login.
        header('Location:login.php');
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <title>Cookbook Website</title>
</head>
<body class="bg-light">
    <div class="full-screen d-flex align-items-center">
        <form action="register.php" method="post" class="form-signin floating-labels">
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Create an Account</h1>
            </div>

            <div class="form-label-group">
                <input type="text" name="name" id="input-name" class="form-control" placeholder="Name" required>
                <label for="input-name">Name</label>
            </div>

            <div class="form-label-group">
                <input type="text" name="surname" id="input-surname" class="form-control" placeholder="Surname" required>
                <label for="input-surname">Surname</label>
            </div>

            <div class="form-label-group">
                <input type="text" name="username" id="input-username" class="form-control" placeholder="Username" required>
                <label for="input-username">Username</label>
            </div>
    
            <div class="form-label-group">
                <input type="email" name="email" id="input-email" class="form-control" placeholder="Email address" required>
                <label for="input-email">Email address</label>
            </div>
    
            <div class="form-label-group">
                <input type="password" name="password" id="input-password" class="form-control" placeholder="Password" required>
                <label for="input-password">Password</label>
            </div>
        
            <div class="form-label-group">
                <input type="password" name="password-again" id="input-password-again" class="form-control" placeholder="Re-enter Password" required>
                <label for="input-password-again">Re-enter Password</label>
            </div>

            <div class="mb-3 text-right">
                <a href="login.php">Sign In</a>
            </div>
        
            <button type="submit" class="btn btn-lg btn-primary btn-block">Create your account</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>