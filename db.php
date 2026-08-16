<?php
// db.php - PDO MySQL connection for verdant_tech_db

$host = '127.0.0.1'; 
$db   = 'verdant_tech_db';
$user = 'root';
$pass = '';
$port = '3307'; // Match your XAMPP MySQL port
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    error_log('Database connection error: ' . $e->getMessage());
    exit('Database connection error. Please try again later.');
}
?>