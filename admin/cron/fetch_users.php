<?php
require_once __DIR__ . '/../../config/db.php';

try {
    $stmt = $pdo->query("SELECT email, level FROM users WHERE sub_status = 'paid'");
    $users = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[] = [
            'email' => $row['email'],
            'level' => substr(strtolower($row['level']), 0, 1)
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($users);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB error', 'message' => $e->getMessage()]);
}