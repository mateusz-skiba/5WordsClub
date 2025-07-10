<?php

function saveLeads(array $data) {
    require __DIR__ . '/../../config/db.php';

    $email = $data['email'] ?? null;
    $level = $data['level'] ?? null;
    $lang = $data['lang'] ?? null;
    $refer = $data['refer'] ?? null;
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    if (!$email || !$level) {
        return 'Missing email or level';
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO leads (email, level, lang, refer, ip) 
            VALUES (:email, :level, :lang, :refer, :ip)
        ");

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':level', $level, PDO::PARAM_STR);
        $stmt->bindValue(':lang', $lang, PDO::PARAM_STR);
        $stmt->bindValue(':refer', $refer, PDO::PARAM_STR);
        $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
        $stmt->execute();

        return 'success';

    } catch (PDOException $e) {
        error_log("DB error: " . $e->getMessage());
        return 'There was a problem saving data. Please try again later.';
    }
}
