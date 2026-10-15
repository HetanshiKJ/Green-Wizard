<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit();
}
$user_id = $_SESSION['user_id']; // Get the logged-in user's ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Actions</title>
</head>
<body>
<form action="save_action.php" method="POST">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> <!-- ✅ Correct user ID -->
    <select name="action_id">
        <option value="1">Use a reusable water bottle</option>
        <option value="2">Walk instead of driving</option>
    </select>
    <button type="submit">Select Action</button>
</form>
</body>
</html>
