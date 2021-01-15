<?php
    // use $_GET if you need a return url
    // $returnURL = $_GET['returnURL'];

    // Logs the user out of the system by deleting the cookies.
    $keys = ['userID', 'groupID', 'firstName', 'lastName'];
    foreach ($keys as $key)
    {
        setcookie($key, '', time() - 3600, '/');
    }

    // header("Location:{$returnURL}.php");
    header('Location:login.php');
?>