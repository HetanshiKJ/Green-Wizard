<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch completed actions count
$completedActionsQuery = "SELECT COUNT(*) AS total FROM user_selected_actions WHERE user_id = $user_id AND status = 'completed'";
$completedActionsResult = $conn->query($completedActionsQuery);
$actionsAchieved = $completedActionsResult->fetch_assoc()['total'] ?? 0;

// Fetch total selected actions count
$totalActionsQuery = "SELECT COUNT(*) AS total FROM user_selected_actions WHERE user_id = $user_id";
$totalActionsResult = $conn->query($totalActionsQuery);
$totalActions = $totalActionsResult->fetch_assoc()['total'] ?? 0;

// Fetch user's pending actions
$pendingActionsQuery = "
    SELECT a.name, usa.status, usa.selected_at 
    FROM user_selected_actions usa
    JOIN actions a ON usa.action_id = a.id
    WHERE usa.user_id = $user_id AND usa.status = 'pending'
    ORDER BY usa.selected_at DESC ";
$pendingActionsResult = $conn->query($pendingActionsQuery);
$pendingActions = [];
while ($row = $pendingActionsResult->fetch_assoc()) {
    $pendingActions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="usercss.css">
    <link rel="stylesheet" href="navigation_bar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    
</head>
<body>
    <!-- <div class="header"> -->
        
        <!-- <h2>Dashboard</h2> -->
        <header id="header">
            <nav class="nav">
                <a href="index.html">Home<span></span></a>
                <a href="calculator.html">Calculator<span></span></a>
                <!-- <a href="#About">About Us<span></span></a> -->
                <!-- <a href="#Footer">Contact<span></span></a> -->
                <!-- <a href="login-form.php">Sign Up<span></span></a> -->
                <a href="results.php">Emissions</a>
                <a href="category.php">Actions</a>
                <a href="projectdone/home.php">Eco Shop<span></span></a>
            </nav>
            <div id="user-btn" onclick="toggleMenu()">
                <i class="fas fa-user"></i>
            </div>
                <div class="dropdown" id="dropdownMenu">
                    <ul class="menu-content">
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>
        
    <!-- </div> -->

    

    <div class="container">
        <div class="card">
            <h3>🌱 Actions Progress</h3>
            <div class="progress-bar">
                <div class="progress" style="width: <?= ($totalActions > 0) ? min(100, ($actionsAchieved / $totalActions) * 100) : 0 ?>%;"></div>
            </div>
            <p><?= $actionsAchieved ?> out of <?= $totalActions ?> Actions Completed</p>
        </div>

        <div class="card">
            <h3>⏳ Pending Actions</h3>
            <?php if (count($pendingActions) > 0): ?>
                <?php foreach ($pendingActions as $action): ?>
                    <p><?= htmlspecialchars($action['name']) ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No pending actions.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // function toggleMenu() {
        //     var menu = document.getElementById("dropdownMenu");
        //     menu.style.display = (menu.style.display === "block") ? "none" : "block";
        // }
        function toggleMenu() {
            var menu = document.getElementById("dropdownMenu");
            console.log("Toggling menu. Current state:", menu.style.display);
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }
    </script>
</body>
</html>
