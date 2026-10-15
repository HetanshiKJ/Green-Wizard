<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);
   $phone = $_POST['phone'];
   $phone = filter_var($phone, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT); // Secure Hash
   $cpass = $_POST['cpass'];

   // Check if email already exists
   $select_seller = $conn->prepare("SELECT * FROM `seller` WHERE email = ?");
   $select_seller->execute([$email]);

   if($select_seller->rowCount() > 0){
      $message[] = 'Email already exists!';
   } else {
      if (!password_verify($cpass, $pass)) { // Compare plain text confirm pass with hashed pass
         $message[] = 'Passwords do not match!';
      } else {
         // Insert seller into the database
         $insert_seller = $conn->prepare("INSERT INTO `seller` (name, email, password, phone, address) VALUES (?,?,?,?,?)");
         $insert_seller->execute([$name, $email, $pass, $phone, $address]);

         $message[] = 'Seller registered successfully!';
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
   <title>Seller Registration</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/seller_header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Register as a Seller</h3>
      <p>Registered Seller? <span><a href="seller_login.php">Login Now.</a></span></p>
      <input type="text" name="name" required placeholder="Enter your full name" maxlength="100" class="box">
      <input type="email" name="email" required placeholder="Enter your email" maxlength="100" class="box">
      <input type="text" name="phone" required placeholder="Enter your phone number" maxlength="15" class="box">
      <textarea name="address" required placeholder="Enter your address" maxlength="255" class="box"></textarea>
      <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="box">
      <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="20" class="box">
      <input type="submit" value="Register Now" class="btn" name="submit">
   </form>
</section>
<p>Registered Seller? <a href="seller_login.php">Login now</a></p>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
