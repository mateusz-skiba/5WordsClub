<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require __DIR__ . '/../../config/db.php';

$email = $_POST['email'];
$level = $_POST['level'];

$stmt = $pdo->prepare("INSERT INTO waitlist (email, level) VALUES (:email, :level)");

if ($stmt->execute(['email' => $email, 'level' => $level])) {
    echo 'success';
} else {
    echo 'error';
}
?>