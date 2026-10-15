<?php
    session_start();
    include 'connect.php';

    if (isset($_POST['signIn'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) { // Verifying Hashed Password
                $_SESSION['user_id'] = $row['user_id']; // ✅ Correctly store user ID
                $_SESSION['email'] = $row['email'];
                
                header("Location: user.php");
                exit();
            } else {
                echo "<script>alert('Incorrect password! Please try again.'); window.location.href='login-form.php';</script>";
            }
        } else {
            echo "<script>alert('No account with this email found.'); window.location.href='login-form.php';</script>";
        }
    }
?>
