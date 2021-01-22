<?php
    include 'libraries/database.php';

    $cart = isset($_COOKIE['cart']) ? $_COOKIE['cart'] : '';
    $filteredCart = [];
    $subtotal = 0;

    if ($cart != '')
    {
        $cart = explode(' ', $cart);
        foreach ($cart as $pk)
        {
            if (isset($filteredCart[$pk]))
            {
                $filteredCart[$pk]['amount']++;
            }
            else
            {
                $filteredCart[$pk] = [
                    'details' => getCuisine($pk),
                    'amount' => 1
                ];
            }

            $subtotal += $filteredCart[$pk]['details']['price'];
        }
    }
?>

<?php if (count($filteredCart) == 0): ?>
    There are no items in your shopping cart.
<?
    else:
        foreach ($filteredCart as $item):
?>
    <div>
        <strong>Item: </strong> <?= $item['details']['name']; ?>
        <br>
        <strong>Amount: </strong> <?= $item['amount']; ?>
        <br>
        <strong>Price: </strong> &euro; <?= 1.99 * $item['amount']; ?>
    </div>
    <br>
<?php endforeach; endif; ?>

Subtotal: &euro;<?= $subtotal; ?>