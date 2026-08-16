<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($full_name === '' || $email === '' || $subject === '' || $message === '') {
    echo json_encode(['success' => false, 'message' => 'Please fill out all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

try {
    // Ensure contacts table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(150) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    $stmt = $pdo->prepare('INSERT INTO contacts (full_name, email, subject, message) VALUES (:full_name, :email, :subject, :message)');
    $stmt->execute([
        ':full_name' => $full_name,
        ':email' => $email,
        ':subject' => $subject,
        ':message' => $message,
    ]);

    echo json_encode(['success' => true, 'message' => 'Thank you — your message has been received.']);
    exit;
} catch (PDOException $e) {
    error_log('Contact form insert error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error — please try again later.']);
    exit;
}
