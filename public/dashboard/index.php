<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /dashboard/login/");
    exit();
}

$user = $_SESSION['user'];

require_once __DIR__ . '/../../config/db.php';

$level = '';
try {
    $stmt = $pdo->prepare("SELECT level FROM users WHERE email = ?");
    $stmt->execute([$user['email']]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        $level = $userData['level'];
    } else {
        $level = "Not found account.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
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
            <div class="support">
                <a href="mailto:contact@5words.club">
                    <img src="/assets/img/supportIcon.svg" alt="">
                </a>
                <div class="tooltip">
                    Talk to support
                </div>
            </div>
        </div>
    </header>
    <main class="dashboard">
        <div class="container">
            <nav>
                <ul>
                    <li>
                        <a href="#" class="active">
                            <div class="avatarBox"><?= htmlspecialchars(substr($user['email'], 0, 1)) ?></div>
                            <span>Account</span>
                        </a>
                    </li>
                    <li>
                        <a href="" target="_blank" id="billingLink">
                            <div class="imgBox">
                                <img src="/assets/img/billingIcon.svg" alt="" class="default">
                                <img src="/assets/img/billingIcon.svg" alt="" class="white">
                            </div>
                            <span>Billing</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout" class="logoutLink">
                            <div class="imgBox">
                                <img src="/assets/img/logoutIcon.svg" alt="" class="default">
                                <img src="/assets/img/logoutIconW.svg" alt="" class="white">
                            </div>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <section class="account">
                <article>
                    <h2>Your Account</h2>
                    <div class="accountInfo">
                        <span class="name" id="email"><?= htmlspecialchars($user['email']) ?></span>
                        <span class="status">Active</span>
                    </div>
                    <h2>Your language level</h2>
                    <div class="languagePill"><?= htmlspecialchars(substr_replace($level, '1-2', 2, 0)) ?></div>
                </article>
                <article>
                    <h2>Change language level</h2>
                    <p class="desc">This is the level at which the words sent to your email are tailored.</p>
                    <form action="" id="changeLevel">
                        <div class="levelBox">
                            <div class="pill">
                                <input type="radio" name="level" id="A" value="A" <?= htmlspecialchars($level) === 'A' ? 'checked' : '' ?> />
                                <label for="A">A1-2</label>
                            </div>
                            <div class="pill">
                                <input type="radio" name="level" id="B" value="B" <?= htmlspecialchars($level) === 'B' ? 'checked' : '' ?> />
                                <label for="B">B1-2</label>
                            </div>
                            <div class="pill">
                                <input type="radio" name="level" id="C" value="C" <?= htmlspecialchars($level) === 'C' ? 'checked' : '' ?> />
                                <label for="C">C1-2</label>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary unactive"><span>Change level</span></button>
                    </form>
                </article>
            </section>
        </div>
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