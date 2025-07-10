<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require_once __DIR__ . '/../src/database/save_user.php';
require_once __DIR__ . '/../src/mailer/hello_mail.php';

$stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);
$endpoint_secret = $_ENV['STRIPE_WEBHOOK_SECRET'];

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(\UnexpectedValueException $e) {
    http_response_code(400);
    exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    exit();
}

switch ($event->type) {
case 'checkout.session.completed':
    $session = $event->data->object;
    $email = $session->customer_details->email;
    $level = isset($session->metadata->level) ? $session->metadata->level : null;

    $sub_status = $session->payment_status;
    $sub_start_date = date('Y-m-d H:i:s');

    $stripeCustomerId = $session->customer;

    $token = bin2hex(random_bytes(16));
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);

    if (empty($email) || empty($level) || empty($stripeCustomerId)) {
        http_response_code(400);
        exit();
    }

    $result = saveUser($email, $level, $sub_status, $sub_start_date, $hashedToken, $stripeCustomerId);

    if ($result === true) {
        $mailResult = sendHelloEmail($email, $level, $token);
    }

    break;
    default:
}

// case 'invoice.paid':
//     $subscription = $event->data->object->subscription;
//     // Odśwież datę ważności, status = active
//     break;

// case 'invoice.payment_failed':
//     $subscription = $event->data->object->subscription;
//     // Ustaw status np. pending_payment / wyślij maila
//     break;

// case 'customer.subscription.deleted':
//     $subscription = $event->data->object;
//     $customerId = $subscription->customer;
//     // status = cancelled, usuń dostęp
//     break;

// case 'customer.subscription.updated':
//     $subscription = $event->data->object;
//     if ($subscription->cancel_at_period_end) {
//         // Ustaw "subskrypcja wygasa z końcem okresu"
//     }
//     break;

http_response_code(200);