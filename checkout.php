<?php
// Simple checkout handler: record order (if orders table exists) and clear cart
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/db.php';

if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['error_message'] = 'Your cart is empty.';
    header('Location: ' . (defined('BASE_URL') ? BASE_URL : '/AsmaAssa2471_Project/') . 'products.php');
    exit;
}

try {
    // Start transaction
    $pdo->beginTransaction();

    // Ensure orders table exists (best-effort)
    $stmt = $pdo->prepare("SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'orders' LIMIT 1");
    $stmt->execute();
    $hasOrders = (bool)$stmt->fetchColumn();

    if ($hasOrders) {
        // Insert order summary
        $stmt = $pdo->prepare('INSERT INTO orders (created_at) VALUES (NOW())');
        $stmt->execute();
        $orderId = $pdo->lastInsertId();

        // Insert order items
        $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)');
        foreach ($_SESSION['cart'] as $pid => $item) {
            $itemStmt->execute([
                ':order_id' => $orderId,
                ':product_id' => intval($item['product_id']),
                ':quantity' => intval($item['quantity']),
                ':price' => floatval($item['price'] ?? 0),
            ]);
        }
    }

    $pdo->commit();
    // Clear cart
    $_SESSION['cart'] = [];
    $_SESSION['success_message'] = 'Checkout complete. Thank you for your order.';
} catch (Exception $e) {
    $pdo->rollBack();
    error_log('Checkout error: ' . $e->getMessage());
    $_SESSION['error_message'] = 'There was a problem processing your order. Please try again.';
}

header('Location: ' . (defined('BASE_URL') ? BASE_URL : '/AsmaAssa2471_Project/') . 'products.php');
exit;
