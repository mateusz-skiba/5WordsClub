<?php
session_start();

// Load user data
$user = $_SESSION['user'];

echo '<pre>';
print_r($user);
echo '</pre>';