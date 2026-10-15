<?php
include 'connect.php';

$message = ""; // Variable to store the message

if (isset($_POST['resetPassword'])) {
    $email = $_POST['email'];

    $checkUser = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50)); // Generate a random token
        $resetLink = "http://localhost/LoginCopy/reset-password.php?token=$token"; // Correct URL

        // Store token in the database
        $conn->query("UPDATE users SET reset_token='$token' WHERE email='$email'");

        // Send email
        $subject = "Password Reset";
        $emailBody = "Click here to reset your password: '$resetLink' ";
        $headers = "From: jadhavhetanshi@gmail.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if (mail($email, $subject, $emailBody, $headers)) {
            $message = "Password reset link sent to your email.";
        } else {
            $message = "Error sending email.";
        }
    } else {
        $message = "No account found with this email.";
    }
}    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <style>
        .fa-envelope {
            position: relative;
            left: -1.3em;
            top: 1rem;
        }
        form {
            margin-top: 100px;
        }
        .main-container {
            display: flex;
            flex-direction: row;
            width: 40vw;
            height: 30vh;
            position: absolute;
            align-items: center;
            justify-content: center;
            margin: auto 0px;
            transform: translate(-50%, -50%);
        }
        .btn {
            border-radius: 10px;
        }
        .container {
            border-radius: 40px;
            box-shadow: 5px 5px 10px grey;
        }
        body {
            background-image: url(Images/gradient.jpg);
            font-family: 'Manrope';
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            color: hsl(327,90%,28%);
            display: <?php echo empty($message) ? 'none' : 'block'; ?>;
        }
        .btn:focus,
        .btn:active {
            outline: none;
            background-color: #4d6641 !important; /* Keep the original background color */
            color: white !important; /* Keep text color */
            box-shadow: none !important; /* Remove any unwanted glow effect */
            outline: none !important;  /* Removes the default browser outline */
            border: none !important;   /* Ensures no border appears */
        }


    </style>
</head>
<body>
    <div class="main-container">
        <div class="container">
            <p class="form-title">Forgot Password?</p>
            <form method="post">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email" required>
                <label for="email">Enter your email</label>
                <input type="submit" class="btn" value="Reset Password" name="resetPassword">
            </form>
            <!-- Display the message inside the container -->
            <div class="message"><?php echo $message; ?></div>
        </div>
    </div>
</body>
</html>
