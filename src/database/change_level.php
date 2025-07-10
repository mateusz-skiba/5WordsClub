<?php
function changeLevel(array $data) {
    require __DIR__ . '/../../config/db.php';

    if (!isset($data['email'], $data['level'])) {
        return ['status' => 'error', 'message' => 'Missing required data.'];
    }

    $email = $data['email'];
    $newLevel = $data['level'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET level = ?, updated_at = NOW() WHERE email = ?");
        $stmt->execute([$newLevel, $email]);

        return ['status' => 'success', 'message' => 'The language level has been updated'];
    } catch (PDOException $e) {
        return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
}
