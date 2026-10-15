<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

// Check if a seller is being deleted
if(isset($_GET['delete_seller'])){
   $delete_id = $_GET['delete_seller'];

   // Delete products uploaded by the seller
   $delete_products = $conn->prepare("DELETE FROM `products` WHERE seller_id = ?");
   $delete_products->execute([$delete_id]);

   // Delete seller account
   $delete_seller = $conn->prepare("DELETE FROM `seller` WHERE id = ?");
   $delete_seller->execute([$delete_id]);

   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Seller Accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">Seller Accounts</h1>

   <div class="box-container">

   <?php
      $select_sellers = $conn->prepare("SELECT * FROM `seller`");
      $select_sellers->execute();
      if($select_sellers->rowCount() > 0){
         while($fetch_seller = $select_sellers->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> Seller ID : <span><?= $fetch_seller['id']; ?></span> </p>
      <p> Name : <span><?= $fetch_seller['name']; ?></span> </p>
      <p> Email : <span><?= $fetch_seller['email']; ?></span> </p>
      <p> Phone : <span><?= $fetch_seller['phone']; ?></span> </p>
      <p> Address : <span><?= $fetch_seller['address']; ?></span> </p>
      <a href="users_accounts.php?delete_seller=<?= $fetch_seller['id']; ?>" 
         onclick="return confirm('Are you sure you want to delete this seller? All their products will be deleted too!')" 
         class="delete-btn">Delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No sellers available!</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
