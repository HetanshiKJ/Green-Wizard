<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Green Wizard</title>
   <link rel="stylesheet" href="css/footer_style.css">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-11.png" alt="">
         </div>
         <div class="content">
            <span>Upto 50% Off</span>
            <h3>Tableware</h3>
            <a href="category.php?category=tableware" class="btn">Shop Now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-22.png" alt="">
         </div>
         <div class="content">
            <span>Upto 50% off</span>
            <h3>Care</h3>
            <a href="category.php?category=care" class="btn">Shop Now.</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-33.png" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <h3>Backpacks</h3>
            <a href="category.php?category=travel" class="btn">Shop Now.</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<section class="category">

   <h1 class="heading">Shop by Category</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=care" class="swiper-slide slide">
      <img src="images/icon-1.png" alt="">
      <h3>Care</h3>
   </a>

   <a href="category.php?category=fashion" class="swiper-slide slide">
      <img src="images/icon-2.png" alt="">
      <h3>Fashion</h3>
   </a>

   <a href="category.php?category=food" class="swiper-slide slide">
      <img src="images/icon-3.png" alt="">
      <h3>Food</h3>
   </a>

   <a href="category.php?category=cleaningsupplies" class="swiper-slide slide">
      <img src="images/icon-4.png" alt="">
      <h3>Cleaners</h3>
   </a>

   <a href="category.php?category=petcare" class="swiper-slide slide">
      <img src="images/icon-5.png" alt="">
      <h3>Pet Care</h3>
   </a>

   <a href="category.php?category=Home Decor" class="swiper-slide slide">
      <img src="images/icon-6.png" alt="">
      <h3>Home Decor</h3>
   </a>

   <a href="category.php?category=bathlinen" class="swiper-slide slide">
      <img src="images/icon-7.png" alt="">
      <h3>Bath Linens</h3>
   </a>

   <a href="category.php?category=gardening" class="swiper-slide slide">
      <img src="images/icon-8.png" alt="">
      <h3>Gardening</h3>
   </a>

   <a href="category.php?category=tableware" class="swiper-slide slide">
      <img src="images/icon-9.png" alt="">
      <h3>Tableware</h3>
   </a>

   <a href="category.php?category=toys" class="swiper-slide slide">
      <img src="images/icon-10.png" alt="">
      <h3>Toys</h3>
   </a>


   <a href="category.php?category=office" class="swiper-slide slide">
      <img src="images/icon-11.png" alt="">
      <h3>Office</h3>
   </a>

   <a href="category.php?category=travel" class="swiper-slide slide">
      <img src="images/icon-12.png" alt="">
      <h3>Travel</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="home-products">

   <h1 class="heading">Latest products</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>INR </span><?= $fetch_product['price']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<!-- Swiper JS (Updated CDN) -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- Custom Script -->
<script src="js/script.js"></script>

<script>
window.onload = function () {
   var swiper1 = new Swiper(".home-slider", {
      loop: true,
      spaceBetween: 20,
      pagination: {
         el: ".swiper-pagination",
         clickable: true,
      },
   });

   var swiper2 = new Swiper(".category-slider", {
      loop: false,
      spaceBetween: 20,
      pagination: {
         el: ".swiper-pagination",
         clickable: true,
      },
      breakpoints: {
         0: { slidesPerView: 2 },
         650: { slidesPerView: 3 },
         768: { slidesPerView: 4 },
         1024: { slidesPerView: 5 },
      },
   });

   var swiper3 = new Swiper(".products-slider", {
      loop: false,
      spaceBetween: 20,
      pagination: {
         el: ".swiper-pagination",
         clickable: true,
      },
      breakpoints: {
         550: { slidesPerView: 2 },
         768: { slidesPerView: 2 },
         1024: { slidesPerView: 3 },
      },
   });
};
</script>

</body>
</html>
