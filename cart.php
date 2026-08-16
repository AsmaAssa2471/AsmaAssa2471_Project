<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/AsmaAssa2471_Project/');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'products.php');
    exit;
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
$price = isset($_POST['price']) ? (float)$_POST['price'] : null;

if ($product_id <= 0 || $quantity < 1) {
    $_SESSION['error_message'] = 'Invalid product or quantity.';
    header('Location: ' . BASE_URL . 'products.php');
    exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add or update product quantity in cart (cart keyed by product_id)
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = [
        'product_id' => $product_id,
        'quantity' => $quantity,
        'price' => $price,
    ];
}

$_SESSION['success_message'] = 'Item added to cart successfully!';

// Redirect back to product detail or cart view
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : (BASE_URL . 'product-detail.php?id=' . $product_id);
header('Location: ' . $redirect);
exit;
