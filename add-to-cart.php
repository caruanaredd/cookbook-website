<?php
    $id = $_GET['id'];
    
    $cart = $_COOKIE['cart'];
    $cart = explode(' ', $cart);
    $cart[] = $id;

    setcookie('cart', implode(' ', $cart), time() + 60 * 60 * 24, '/');
    
    header('Location:' . $_SERVER['HTTP_REFERER']);
?>