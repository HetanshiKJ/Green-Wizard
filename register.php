<?php 
include 'connect.php';

if(isset($_POST['signUp'])) {
    // $firstName = $_POST['fName'];
    // $lastName = $_POST['lName'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing Password

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        // $insertQuery = "INSERT INTO users (fName, lName, email, password) 
        //                 VALUES ('$firstName', '$lastName', '$email', '$password')";
        $insertQuery = "INSERT INTO users (name, email, password) 
                        VALUES ('$name', '$email', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: login-form.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
