<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

function createCheckoutSession(array $data) {
    header('Content-Type: application/json');

    \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

    $level = $_POST['level'] ?? null;
    $email = $_POST['email'] ?? null;
    $lang = $_POST['lang'];

    $valid_langs = ['pl', 'en'];

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid email']);
        exit;
    }

    if (!in_array($lang, $valid_langs)) {
        $lang = 'pl';
    }

    $price_pln = $_ENV['PRICE_PLN'];
    $price_eur = $_ENV['PRICE_EUR'];

    $price_id = $lang === 'pl' ? $price_pln : $price_eur;
    $cancel_url = $lang === 'pl' ? 'https://5words.club/pl/' : 'https://5words.club';
    $success_url = $lang === 'pl' ? 'https://5words.club/pl/thankyou?email=' . urlencode($email) . '&level=' . urlencode($level) : 'https://5words.club/thankyou?email=' . urlencode($email) . '&level=' . urlencode($level);

    try {
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'customer_email' => $email,
            'line_items' => [[
                'price' => $price_id,
                'quantity' => 1,
            ]],
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
            'metadata' => [
                'level' => $level,
                'description' => 'English level: ' . $level,
            ],
        ]);
        echo json_encode(['id' => $session->id]);
        exit;
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Something went wrong, please try again']);
        exit;
    }
}