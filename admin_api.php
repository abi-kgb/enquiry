<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'list') {
    $query = "SELECT * FROM enquiries ORDER BY date DESC";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    echo json_encode($rows);
} elseif ($action === 'delete') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $query = "DELETE FROM enquiries WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Invalid ID"]);
    }
} else {
    echo json_encode(["error" => "Invalid action"]);
}

mysqli_close($conn);
?>
