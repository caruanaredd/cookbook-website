<?php
    include 'libraries/database.php';

    $cuisines = getAllCuisines();
    $cart = $_COOKIE['cart'];
    $cart = explode(' ', $cart);

    echo "Your cart: ", count($cart), " items.";

    while ($cuisine = mysqli_fetch_assoc($cuisines)):
?>
    <div>
        <?= $cuisine['name']; ?>
        <a href="add-to-cart.php?id=<?= $cuisine['cuisineID']; ?>">Add to Cart</a>
    </div>
<?php endwhile; ?>

<a href="shopping-cart.php">My Shopping Cart</a>