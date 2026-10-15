<?php

include '../components/connect.php';


session_start();
if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass']; // Do not hash it here

   $select_seller = $conn->prepare("SELECT * FROM `seller` WHERE name = ?");
   $select_seller->execute([$name]);
   $row = $select_seller->fetch(PDO::FETCH_ASSOC);

   if($row && password_verify($pass, $row['password'])) { // Correctly verify the hashed password
      $_SESSION['seller_id'] = $row['id'];
      header('location:dashboard.php');
   } else {
      $message[] = 'Incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<section class="form-container">

   <form action="" method="post">
      <h3>Login now</h3>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" class="btn" name="submit">
   </form>

</section>
   
</body>
</html>