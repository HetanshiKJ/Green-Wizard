<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Assuming the actions table is named 'actions' and has 'id' (matching action_id) and 'name' columns
$sql = "SELECT usa.id, a.name, usa.status 
        FROM user_selected_actions usa
        JOIN actions a ON usa.action_id = a.id
        WHERE usa.user_id = ? AND usa.status = 'pending'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$actions = [];
while ($row = $result->fetch_assoc()) {
    $actions[] = $row;
}

echo json_encode($actions);

$stmt->close();
$conn->close();
?>
