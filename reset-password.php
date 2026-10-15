<?php
include 'connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatePassword'])) {
    $token = $_POST['token'] ?? ''; // Get token from hidden input field
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Check if token is valid
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE reset_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];

            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password and remove the token
            $update_stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE user_id = ?");
            $update_stmt->bind_param("si", $hashed_password, $user_id);

            if ($update_stmt->execute()) {
                $message = "Password updated successfully.";
            } else {
                $message = "Error updating password.";
            }

            $update_stmt->close();
        } else {
            $message = "Invalid or expired token.";
        }

        $stmt->close();
    }
}

// Get token from URL when page is loaded
$token = $_GET['token'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <style>
       @font-face {
    font-family: "mestika";
    src: url("fonts/Mestika.otf");
}

@font-face {
    font-family: "botham";
    src: url("fonts/Botham-Reguler.otf");
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Manrope', sans-serif;
}

body {
    background: url(Images/gradient.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Centered Main Section */
.container {
    background: #f0f7e2;
    width: 40vw;
    height: 70vh;
    padding: 50px;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Title */
.form-title {
    font-size: 30px;
    margin: 50px 0px;
    font-family: 'mestika';
    color: #333;
}

/* Input Fields */
.input-group {
    position: relative; /* Ensures icons position relative to input */
    margin-bottom: 25px;
    display: flex;
    align-items: center;
}

.input-group i {
    position: absolute;
    left: 12px; /* Adjust distance from the left */
    top: 50%;
    transform: translateY(-50%);
    color: black;
    font-size: 16px;
}
.input-group input {
    width: 100%;
    background-color: transparent;
    border: none;
    border-bottom: 1px solid #757575;
    padding: 12px 12px 12px 40px;
    padding-left: 35px; /* Push text to the right so it doesn’t overlap the icon */
    font-size: 16px;
}

input:focus {
    border-bottom: 2px solid hsl(327, 90%, 28%);
    outline: none;
}

input::placeholder {
    color: transparent;
}

/* Floating Labels */
label {
    color: #757575;
    position: absolute;
    left: 40px;
    top: 12px;
    transition: 0.3s ease all;
    font-size: 16px;
}

input:focus~label, input:not(:placeholder-shown)~label {
    top: -15px;
    left: 10px;
    color: hsl(327, 90%, 28%);
    font-size: 14px;
}


.message{
    color: hsl(327, 90%, 28%);
}

/* Forgot Password Link */
.recover {
    text-align: right;
    font-size: 1rem;
    margin-bottom: 1rem;
}

.recover a {
    text-decoration: none;
    color: #4d6641;
}

.recover a:hover {
    color: black;
    text-decoration: underline;
}

/* Submit Button */
.btn {
    font-size: 1.1rem;
    padding: 12px;
    border-radius: 10px;
    outline: none;
    border: none;
    width: 100%;
    background: #4d6641;
    color: white;
    cursor: pointer;
    transition: background 0.5s;
    margin-top: 50px;
    width: 400px;
}

.btn:hover {
    background: #07001f;
}

/* Links */
.links {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
    margin-top: 30px;
    font-weight: bold;
    padding: 10px 20px;
}

button {
    color: #4d6641;
    border: none;
    background-color: transparent;
    font-size: 1rem;
    font-weight: bold;
}

button:hover {
    text-decoration: underline;
    color: black;
    cursor: pointer;
}



    </style>
</head>
<body>
    <div class="main-container">
        <div class="container">
            <p class="form-title">Reset Password</p>

            <?php if ($message): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>

            <form method="post" action="reset-password.php">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="new_password" id="new_password" placeholder=" " required>
                    <label for="new_password">New Password</label>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder=" " required>
                    <label for="confirm_password">Confirm Password</label>
                </div>

                <input type="submit" class="btn" value="Update Password" name="updatePassword">

                <div class="links">
                    <button class="SignInButton" type="button" onclick="window.location.href='index.php'">Sign In</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
