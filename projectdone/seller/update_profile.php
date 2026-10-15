<?php

include '../components/connect.php';

session_start();

// Ensure seller ID is set in the session
if (!isset($_SESSION['seller_id'])) {
   header('location:seller_login.php');
   exit();
}

$seller_id = $_SESSION['seller_id'];

// Fetch seller details before displaying the form
$select_seller = $conn->prepare("SELECT * FROM `seller` WHERE id = ?");
$select_seller->execute([$seller_id]);
$fetch_profile = $select_seller->fetch(PDO::FETCH_ASSOC);

// Debugging: Check if seller data is found
if (!$fetch_profile) {
   die("Error: No seller found with ID $seller_id"); // Stop execution if no seller is found
}
if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   
   // Update name
   $update_profile_name = $conn->prepare("UPDATE `seller` SET name = ? WHERE id = ?");
   $update_profile_name->execute([$name, $seller_id]);

   $prev_pass = $fetch_profile['password']; // Fetch stored hashed password
   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];

   if (empty($old_pass)) {
      $message[] = 'Please enter old password!';
   } elseif (!password_verify($old_pass, $prev_pass)) {
      $message[] = 'Old password not matched!';
   } elseif ($new_pass !== $confirm_pass) {
      $message[] = 'Confirm password not matched!';
   } else {
      if (!empty($new_pass)) {
         $hashed_new_pass = password_hash($new_pass, PASSWORD_BCRYPT);
         $update_seller_pass = $conn->prepare("UPDATE `seller` SET password = ? WHERE id = ?");
         $update_seller_pass->execute([$hashed_new_pass, $seller_id]);
         $message[] = 'Password updated successfully!';
      } else {
         $message[] = 'Please enter a new password!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/seller_header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Update Profile</h3>
      <input type="hidden" name="prev_pass" value="<?= htmlspecialchars($fetch_profile['password'] ?? ''); ?>">
      <input type="text" name="name" value="<?= htmlspecialchars($fetch_profile['name'] ?? ''); ?>" required placeholder="Enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="old_pass" placeholder="Enter old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Enter new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="Confirm new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" class="btn" name="submit">
   </form>
</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
