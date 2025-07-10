<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

// If user is logged
if (isset($_SESSION['user'])) {
    header("Location: /dashboard/");
    exit();
}
if (isset($_GET['token']) && isset($_GET['email'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        // echo "The user with the provided email address does not exist";
        header("Location: /dashboard/login?status=not_found");
        exit();

    } else {
        if (!password_verify($token, $user['token'])) {
            // echo "Invalid token";
            header("Location: /dashboard/login?status=invalid_token");
            exit();

        } else {
            $expiryDate = new DateTime($user['token_expiry']);
            $currentDate = new DateTime();

            if ($currentDate > $expiryDate) {
                // echo "Token has expired";
                header("Location: /dashboard/login?status=expired_token");
                exit();

            } else {
                $_SESSION['user'] = $user;
                header("Location: /dashboard/");
                exit();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/icon.png" type="image/x-icon">
    <title>5WordsClub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="/" class="logo">
                <img src="/assets/img/logo.webp" alt="5WordsClub logo">
            </a>
        </div>
    </header>
    <main class="signin">

        <?php
            $status = $_GET['status'] ?? 'login';
            $email = isset($_GET['email']) ? $_GET['email'] : '';
        ?>

        <?php if ($status === 'login'): ?>
            <section class="signin">
                <h1>Sign In</h1>
                <p class="desc">Enter your email, and we’ll send you a one-time login link to access your account.</p>
                <form class="form loginForm">
                    <input type="email" name="email" placeholder="Email" required>
                    <button type="submit" class="btn-primary"><span>Send Login Link</span></button>
                </form>
            </section>

        <?php elseif ($status === 'sent_g'): ?>
            <section class="signin">
                <h1>Link Sent</h1>
                <p class="desc">Check your inbox (and spam folder) for an email sent to <strong><?= htmlspecialchars($email) ?></strong> and click the link to sign in!</p>
                <div class="form">
                    <a href="https://mail.google.com/" target="_blank" class="btn-primary">
                        <span>Open Email Inbox <img src="/assets/img/arrow.svg" class="skew" alt=""></span>
                    </a>
                </div>
            </section>

        <?php elseif ($status === 'sent'): ?>
            <section class="signin">
                <h1>Link Sent</h1>
                <p class="desc">Check your inbox (and spam folder) for an email sent to <strong><?= htmlspecialchars($email) ?></strong> and click the link to sign in!</p>
            </section>

        <?php elseif ($status === 'not_found'): ?>
            <section class="signin">
                <h1>Account Not Found</h1>
                <p class="desc">The email address you entered is not registered.</p>
                <div class="form">
                    <div class="buttons">
                        <a href="/dashboard/login/" class="btn-secondary"><span>Try again</span></a>
                        <a href="https://buy.stripe.com/test_9AQ6ppefq7Fe7Go3cc?locale=pl&prefilled_email=<?= htmlspecialchars($email) ?>" class="btn-primary"><span>Join  →</span></a>
                    </div>
                </div>
            </section>

        <?php elseif ($status === 'invalid_token'): ?>
            <section class="signin">
                <h1>Invalid Token</h1>
                <p class="desc">The login link is invalid.</p>
                <div class="form">
                    <a href="/dashboard/login/" class="btn-primary"><span>Request New Login Link</span></a>
                </div>
            </section>

        <?php elseif ($status === 'expired_token'): ?>
            <section class="signin">
                <h1>Invalid Token</h1>
                <p class="desc">The login link has expired.</p>
                <div class="form">
                    <a href="/dashboard/login/" class="btn-primary"><span>Request New Login Link</span></a>
                </div>
            </section>

        <?php elseif ($status === 'error'): ?>
            <section class="signin">
                <h1>Error Occurred</h1>
                <p class="desc">Something went wrong. Please try again later.</p>
            </section>

        <?php endif; ?>

    </main>
    <footer>
        <div class="container">
            <p>Copyright © 2025. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/assets/js/dashboard.js"></script>
</body>
</html>