<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/db.php';

try {
    $stmt = $pdo->query("SELECT `set` FROM setcron WHERE id = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        die("No set found");
    }
    $set = (int)$row['set'];

    $stmt = $pdo->query("SELECT email, level FROM users WHERE sub_status = 'paid'");
    $users = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $level = strtolower(substr($row['level'], 0, 1));
        $users[] = [
            'email' => $row['email'],
            'level' => $level
        ];
    }

    foreach ($users as $user) {
        $level = $user['level'];
        $email = $user['email'];

        $_POST['level'] = $level;
        $_POST['set'] = $set;

        ob_start();
        include __DIR__ . '/../words.php';
        $words = ob_get_clean();

        if ($words === false || empty($words)) {
            echo "Failed to fetch words for $email\n";
            continue;
        }

        $_POST['usersMails'] = [$email];
        $_POST['level'] = $level;
        $_POST['mailContent'] = $words;

        ob_start();
        include __DIR__ . '/../send.php';
        $result = ob_get_clean();

        if ($result === false || empty($result)) {
            echo "Failed to send mail to $email\n";
        } else {
            echo "Mail sent to $email\n";
        }
    }

    $pdo->query("UPDATE setcron SET `set` = `set` + 1, updated_at = NOW() WHERE id = 1");

} catch (PDOException $e) {
    die("DB error: " . $e->getMessage());
}