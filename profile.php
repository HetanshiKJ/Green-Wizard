<?php

session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$query = "SELECT name, email, address, avatar FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$avatar = $user['avatar'] ?: 'img/avtar.jpg'; // Default if no avatar uploaded
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_profile'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $updateQuery = "UPDATE users SET name = ?,  email = ?, address = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $name, $email, $address, $user_id);

        if ($stmt->execute()) {
            echo "<script>window.location.href='profile.php';</script>";
        }
    }

    if (isset($_FILES['avatar'])) {
        $file = $_FILES['avatar'];
        if ($file['error'] === 0) {
            $fileName = "avatar_" . $user_id . "_" . time() . ".jpg";
            $filePath = "uploads/" . $fileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $updateAvatarQuery = "UPDATE users SET avatar = ? WHERE user_id = ?";
                $stmt = $conn->prepare($updateAvatarQuery);
                $stmt->bind_param("si", $filePath, $user_id);
                if ($stmt->execute()) {
                    $avatar = $filePath;
                    $successMessage = "Profile picture updated!";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Profile Page</title>
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(229, 236, 214);
            text-align: center;
        }

        .profile-container {
            width: 45%;
            height: 70%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .avatar-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .avatar {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            border: 3px solid white !important;
            cursor: pointer;
        }

        input[type="file"] {
            display: none;
        }

        h2 {
            margin: 10px 0 5px;
        }

        .details {
            text-align: left;
            margin: 0 auto;
            /* margin-top: 50px; */
            width: 50%;
            
        }

        .details p {
            padding: 5px 0;
            /* border-bottom: 1px solid #ddd; */
        }

        .edit-profile, .save-profile {
            width: 200px;
            margin-top: 20px;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            font-family: 'Manrope'
        }

        .save-profile {
            display: none;
        }

        a {
            color: red;
            cursor: pointer;
        }

        input[type="text"], input[type="email"]{
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: none;
            font-size: 16px;
            font-family: "Manrope";
        }
        .heading{
            font-family: "Mestika";
            font-size: 30px;
        }
        
        .clickable {
            cursor: pointer;
            border: 3px solid blue;
        }
        .success-message-div{
            height: 50px;
            /* background-color: yellow; */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .button-container{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-container button{
            font-size:16px;
            padding:8px 0;
            border-radius:10px;
            width:60%;
            color:white;
            background: #4d6641 ;
            cursor:pointer;
            transition:0.5s;
            margin-top: 50px;
        }
        button:hover{
            background:#07001f;
        }
        #nameDisplay{
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <p class="heading">My Profile</p>

        <form method="POST" enctype="multipart/form-data">
            <div class="avatar-container">
                <img src="<?= htmlspecialchars($avatar) ?>" alt="Profile Picture" class="avatar" id="avatar">
                <input type="file" name="avatar" id="avatarInput" accept="image/*">
            </div>

            <h2 id="nameHeading"><?= htmlspecialchars($user['name']) ?></h2>

<!-- Add this new section for editable mode -->
           


            <div class="details">
                <div id="nameEditSection" style="display: none;">
                    <p>
                        <strong>Name:</strong> 
                        <span id="nameDisplay"><?= htmlspecialchars($user['name']) ?></span>
                        <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" style="display: none;">
                    </p>
                </div>
                    

                <p><strong>Email:</strong> <span id="emailDisplay"><?= htmlspecialchars($user['email']) ?></span>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>"></p>

                <p><strong>Address:</strong> <span id="addressDisplay"><?= htmlspecialchars($user['address']) ?></span>
                <input type="text" name="address" id="address" value="<?= htmlspecialchars($user['address']) ?>"></p>
                <p class="sign-out"><a href="logout.php">Sign Out</a></p>
                
                <div class="button-container">
                    <button type="button" class="edit-profile" onclick="enableEditing()">Edit Profile</button>
                    <button type="submit" name="update_profile" class="save-profile" onclick="successMessage()">Save Changes</button>
                </div>
              
            </div>
        </form>

        
    </div>
    <script>
        let isEditing = false;
        function enableEditing() {
            isEditing = true;

            document.querySelector(".edit-profile").style.display = "none";
            document.querySelector(".save-profile").style.display = "inline-block";

            document.getElementById("nameHeading").style.display = "none";
            document.getElementById("nameDisplay").style.display = "none"; // Hide name display
            document.getElementById("name").style.display = "inline-block"; // Show input field

            document.getElementById("nameEditSection").style.display = "block"
            
            document.getElementById("emailDisplay").style.display = "none";
            document.getElementById("email").style.display = "inline-block";
            
            document.getElementById("addressDisplay").style.display = "none";
            document.getElementById("address").style.display = "inline-block";

            document.getElementById("avatar").classList.add("clickable");
        }


        document.getElementById("avatar").addEventListener("click", function () {
            if (isEditing) {
                document.getElementById("avatarInput").click();
            }
        });

        document.getElementById("avatarInput").addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("avatar").src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
        function successMessage(){
                    alert("Profile updated successfully!");
                }
                document.getElementById("avatarInput").addEventListener("change", function (event) {
            const file = event.target.files[0]; // Get the selected file
            if (file) {
                const reader = new FileReader(); // Create a FileReader
                reader.onload = function (e) {
                    document.getElementById("avatar").src = e.target.result; // Update the image preview
                };
                reader.readAsDataURL(file); // Read the file as a data URL
            }
        });

    </script>

</body>
</html>
