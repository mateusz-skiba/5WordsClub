<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$user = $_SESSION['user'];

$customerId = $user['stripe_customer_id'];

if (empty($customerId)) {
    echo json_encode(['status' => 'error', 'message' => 'No Stripe customer ID']);
    exit();
}

try {
    $session = \Stripe\BillingPortal\Session::create([
        'customer' => $customerId,
        'return_url' => 'https://5words.club/dashboard/'
    ]);

    if (!isset($session->url)) {
        echo json_encode(['status' => 'error', 'message' => 'No portal URL returned']);
        exit();
    }

    echo json_encode([
        'status' => 'success',
        'link' => $session->url
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
