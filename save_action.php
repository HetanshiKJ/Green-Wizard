<?php
session_start();
include 'connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "Error: User is not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id']; 
$action_id = $_POST['action_id'] ?? null;

// Check if action_id is provided
if (!$action_id) {
    echo json_encode(["message" => "Error: Action ID is missing."]);
    exit();
}

// Validate user ID
$checkUser = "SELECT user_id FROM users WHERE user_id = ?";
$stmtUser = $conn->prepare($checkUser);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows === 0) {
    echo json_encode(["message" => "Error: User ID does not exist."]);
    exit();
}

// Insert selected action
$sql = "INSERT INTO user_selected_actions (user_id, action_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $action_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Action selected successfully.", "status" => "success"]);
} else {
    echo json_encode(["message" => "Error selecting action: " . $stmt->error, "status" => "error"]);
}

$stmt->close();
$conn->close();
?>




