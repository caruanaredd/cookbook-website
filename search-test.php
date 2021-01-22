<?php
    include 'libraries/database.php';

    $keyword = 'chinese';
    $results = searchCuisines($keyword);

    while ($cuisine = mysqli_fetch_assoc($results))
    {
        var_dump($cuisine);
        echo "<br>";
    }
?>
