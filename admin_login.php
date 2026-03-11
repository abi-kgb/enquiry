<?php
session_start();
header('Content-Type: application/json');

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$ADMIN_USER = "admin";
$ADMIN_PASS = "admin123";

if (isset($data['username']) && isset($data['password'])) {
    if ($data['username'] === $ADMIN_USER && $data['password'] === $ADMIN_PASS) {
        $_SESSION['admin_logged_in'] = true;
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Invalid credentials"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Incomplete request"]);
}
?>
