<?php
require_once __DIR__ . '/db.php';

try {
    $stmt = $pdo->prepare('UPDATE products SET image_path = :default_path');
    $stmt->execute([':default_path' => 'uploads/default.jpg']);
    echo 'Success: All product image paths have been reset to uploads/default.jpg.';
} catch (PDOException $e) {
    error_log('Error updating image paths: ' . $e->getMessage());
    echo 'Error updating image paths. Check logs for details.';
}
