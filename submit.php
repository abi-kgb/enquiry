<?php
include 'db.php';

header('Content-Type: application/json');

// Get JSON data
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if ($data) {
    $name = mysqli_real_escape_with_safe_chars($conn, $data['name']);
    $email = mysqli_real_escape_with_safe_chars($conn, $data['email']);
    $phone = mysqli_real_escape_with_safe_chars($conn, $data['phone']);
    $course = isset($data['course']) ? mysqli_real_escape_with_safe_chars($conn, $data['course']) : 'MCA';
    $message = mysqli_real_escape_with_safe_chars($conn, $data['message']);

    $query = "INSERT INTO enquiries (name, email, phone, course, message) VALUES ('$name', '$email', '$phone', '$course', '$message')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No data received"]);
}

function mysqli_real_escape_with_safe_chars($conn, $str) {
    return mysqli_real_escape_string($conn, $str);
}

mysqli_close($conn);
?>
