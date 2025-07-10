<?php
header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? null;

if (!$action) {
    http_response_code(400);
    echo json_encode(['error' => 'No action specified']);
    exit;
}

switch ($action) {
    case 'save_leads':
        require_once __DIR__ . '/../src/database/save_leads.php';
        $response = saveLeads($_POST);
        echo json_encode($response);
        exit;

    case 'create_checkout_session':
        require_once __DIR__ . '/../src/stripe/create_checkout_session.php';
        $response = createCheckoutSession($_POST);
        echo json_encode($response);
        break;

    case 'send_token':
        require_once __DIR__ . '/../src/mailer/send_token.php';
        $response = sendToken($_POST);
        echo json_encode($response);
        break;

    case 'change_level':
        require_once __DIR__ . '/../src/database/change_level.php';
        echo json_encode(changeLevel($_POST));
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Unknown action']);
        break;
}