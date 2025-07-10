<?php
function saveUser($email, $level, $sub_status, $sub_start_date, $token, $stripeCustomerId = null) {
    require __DIR__ . '/../../config/db.php';

    $expiryDate = date('Y-m-d H:i:s', strtotime('+1 hour'));

    try {
        $stmt = $pdo->prepare("
            INSERT INTO users 
                (email, level, sub_status, sub_start_date, token, token_expiry, stripe_customer_id) 
            VALUES 
                (:email, :level, :sub_status, :sub_start_date, :token, :token_expiry, :stripe_customer_id)
        ");

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':level', $level, PDO::PARAM_STR);
        $stmt->bindValue(':sub_status', $sub_status, PDO::PARAM_STR);
        $stmt->bindValue(':sub_start_date', $sub_start_date, PDO::PARAM_STR);
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->bindValue(':token_expiry', $expiryDate, PDO::PARAM_STR);
        $stmt->bindValue(':stripe_customer_id', $stripeCustomerId, PDO::PARAM_STR);

        $stmt->execute();
        return true;

    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return 'There was a problem saving data. Please try again later.';
    }
}