<?php
include 'connect.php';

$category = $_GET['category'] ?? '';

if (!$category) {
    echo json_encode([]);
    exit();
}

// Fetch name, description, and impact points
$sql = "SELECT id, name, description, impact_score, difficulty_level FROM actions WHERE category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

$actions = [];
while ($row = $result->fetch_assoc()) {
    $actions[] = $row;  // Now includes description & impact points
}

echo json_encode($actions);
?>



