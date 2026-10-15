<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT a.name, usa.status, usa.selected_at 
          FROM user_selected_actions usa
          JOIN actions a ON usa.action_id = a.id
          WHERE usa.user_id = ?
          ORDER BY usa.selected_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$actions = [];
while ($row = $result->fetch_assoc()) {
    $actions[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Actions</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            text-align: center;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #4d6641;
        }

        .actions-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .action-card {
            background: white;
            width: 300px;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            position: relative;
        }

        .action-card:hover {
            transform: scale(1.05);
        }

        .action-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .status {
            font-size: 14px;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .pending {
            background-color: #f7c548;
            color: #855c00;
        }

        .completed {
            background-color: #4CAF50;
            color: white;
        }

        .in-progress {
            background-color: #3498db;
            color: white;
        }

        .date {
            font-size: 14px;
            color: #666;
        }

        .progress-bar {
            height: 5px;
            background: #ddd;
            border-radius: 5px;
            margin-top: 10px;
            overflow: hidden;
        }

        .progress {
            height: 5px;
            width: 0%;
            background: #4CAF50;
            transition: width 1s ease-in-out;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>🌱 My Selected Actions</h2>
        <div class="actions-list">
            <?php if (empty($actions)): ?>
                <p>No actions selected yet.</p>
            <?php else: ?>
                <?php foreach ($actions as $action): ?>
                    <div class="action-card">
                        <div class="action-title"><?= htmlspecialchars($action['name']); ?></div>
                        <div class="status 
                            <?= strtolower($action['status']) === 'pending' ? 'pending' : 
                               (strtolower($action['status']) === 'completed' ? 'completed' : 'in-progress'); ?>">
                            <?= ucfirst($action['status']); ?>
                        </div>
                        <div class="date">📅 Selected on: <?= date("F j, Y", strtotime($action['selected_at'])); ?></div>
                        <div class="progress-bar">
                            <div class="progress" style="width: <?= ($action['status'] === 'Completed') ? '100%' : '50%'; ?>"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const progressBars = document.querySelectorAll(".progress");
            progressBars.forEach(bar => {
                setTimeout(() => {
                    bar.style.width = bar.style.width; // Triggers animation
                }, 300);
            });
        });
    </script>

</body>
</html>
