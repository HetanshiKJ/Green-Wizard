<?php
include '../components/connect.php';

// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$seller_id = $_SESSION['seller_id'] ?? null; // Ensure seller_id is set

if ($seller_id) {
    $select_profile = $conn->prepare("SELECT * FROM `seller` WHERE id = ?");
    $select_profile->execute([$seller_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
} else {
    $fetch_profile = null; // No seller is logged in
}

if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . htmlspecialchars($message) . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>';
    }
}
?>


<header class="header">
   <section class="flex">
      <a href="../seller/dashboard.php" class="logo">Seller<span>Panel</span></a>

      <nav class="navbarseller">
         <a href="../seller/dashboard.php">Home</a>
         <a href="../seller/products.php">Products</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php if ($fetch_profile): ?>
            <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
            <a href="../seller/update_profile.php" class="btn">Update Profile</a>
            <a href="../components/user_logout.php" class="delete-btn" onclick="return confirm('Logout from the website?');">Logout</a>
         <?php else: ?>
            <div class="flex-btn">
               <a href="../seller/register_seller.php" class="option-btn">Register</a>
               <!-- <a href="../seller/register_seller.php" class="option-btn">Register</a> -->
               <!-- <a href="/projectdone/seller/register_seller.php" class="option-btn">Register</a> -->
               <!-- <a href="http://localhost/projectdone/seller/register_seller.php" class="option-btn">Register</a> -->
               <!-- <a href="http://localhost/LoginCopy/projectdone/seller/register_seller.php" class="option-btn">Register</a> -->



               <a href="../seller/seller_login.php" class="option-btn">Login</a>
            </div>
         <?php endif; ?>
      </div>
   </section>
</header>
