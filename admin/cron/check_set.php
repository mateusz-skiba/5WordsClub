<?php
require_once __DIR__ . '/../../config/db.php';

try {
    $stmt = $pdo->query("SELECT `set` FROM setcron WHERE id = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $set = (int) $row['set'];

        $updateStmt = $pdo->prepare("UPDATE setcron SET `set` = `set` + 1, updated_at = NOW() WHERE id = 1");
        $updateStmt->execute();

        echo $set;
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'No set found']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB error', 'message' => $e->getMessage()]);
}