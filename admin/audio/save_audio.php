<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_POST['id'] ?? null;
$audio = $_POST['audio'] ?? null;

if (!$id || !$audio) {
    http_response_code(400);
    echo "Missing id or audio";
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE c_words SET audio = :audio WHERE id = :id");
    $stmt->execute(['audio' => $audio, 'id' => $id]);
    echo "Success";
} catch (PDOException $e) {
    http_response_code(500);
    echo "DB error: " . $e->getMessage();
}