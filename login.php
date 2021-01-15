<?php
    include 'libraries/database.php';
    include 'libraries/form.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // Process the login form.
        $email          = getPostData('email');
        $password       = getPostData('password');

        // Check that the email exists and password validates internally.
        $user = login($email, $password);

        // If not, we'll tell the user that the combination was wrong.
        if (!$user)
        {
            die("The login details were not valid.");
        }

        // If everything validates, we'll set the cookie information.
        // current time + 60 seconds * 60 minutes * 24 hours * X days
        $expiration = time() + 60 * 60 * 24 * 60;
        foreach ($user as $key => $value)
        {
            setcookie($key, $value, $expiration, '/');
        }

        // Redirect to another page.
        header('Location:dashboard/recipes.php');
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
        <form action="login.php" method="post" class="form-signin floating-labels">
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
                <p>Welcome to the Cookbook Dashboard.</p>
            </div>
    
            <div class="form-label-group">
                <input type="email" name="email" id="input-email" class="form-control" placeholder="Email address" required>
                <label for="input-email">Email address</label>
            </div>
    
            <div class="form-label-group">
                <input type="password" name="password" id="input-password" class="form-control" placeholder="Password" required>
                <label for="input-password">Password</label>
            </div>
    
            <div class="d-flex justify-content-between mb-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember-me" id="input-remember-me" value="1"> Remember Me
                    </label>
                </div>
                
                <a href="register.php">Register</a>
            </div>
    
            <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>