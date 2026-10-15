<?php
include 'connect.php';

session_start();
$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id == 0) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$action_id = $data['action_id'] ?? 0;
$status = $data['status'] ?? 'pending';

if (!in_array($status, ['pending', 'completed'])) {
    echo json_encode(["success" => false, "message" => "Invalid status"]);
    exit();
}

$sql = "UPDATE user_selected_actions SET status = ? WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $status, $action_id, $user_id);
$success = $stmt->execute();

echo json_encode(["success" => $success]);
?>
