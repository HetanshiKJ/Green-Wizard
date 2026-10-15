<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="my_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
      .btn{
        border-radius: 10px;
      }
    </style>

</head>
<body>

  <script src="my_script.js" defer></script>

  <div class="main-container">

    <div class="transparent">
      <div id="fact-container">
          <p id="fact-heading"></p>
          <p id="fact-text"></p>
      </div>
    </div>


    <script>
      //display facts
      const facts = [
        { heading: "🛍️1 Reusable Bag = 22,000 Less Plastic Bags!", text: " If just one person switches to using reusable shopping bags, they can prevent an average of 22,000 plastic bags from polluting the environment in their lifetime!" },
        { heading: "⚡Renewable Energy is Growing Fast", text: " The use of renewable energy has tripled worldwide in the last decade, reducing millions of tons of carbon emissions!" },
        { heading: "🌍You Can Offset Your Carbon Footprint", text: " Many companies and organizations now offer carbon offset programs, allowing you to contribute to tree planting, ocean cleanup, and renewable energy projects!" },
        { heading: "♻️Recycling Makes a Difference", text: " Recycling just one aluminum can saves enough energy to run a TV for 3 hours. Small changes lead to big results!" },
        { heading: "🌳7 Trees = 1 Life", text: " Seven trees provide the oxygen you need for a lifetime. Protect them, and they’ll protect you!" },
        { heading: "💡LEDs Light the Way", text: " LED bulbs use 75% less energy and last 25 times longer than traditional bulbs. A simple switch makes a big impact!" },
        { heading: "🌱Plant-Based Choices Save Water", text: " Switching to a plant-based meal just once a week can save over 1,000 gallons of water—that’s enough for two months of showers!" },
        { heading: "🚌 Public Transport = Less Pollution", text: "Taking public transport instead of driving cuts your carbon footprint by 45%, reducing air pollution and traffic congestion!" },
        { heading: "☀️Solar Power Is Booming", text: " Every hour, the sun provides enough energy to power the world for a year—and solar panels are getting cheaper every day!" },
        { heading: "🚲Biking = Clean Air", text: " If just 1% of car trips were replaced with biking, global carbon emissions could drop by millions of tons each year!" }
      ];

      let currentFactIndex = 0;
      const factHeading = document.getElementById("fact-heading");
      const factText = document.getElementById("fact-text");

      function showFact() {
        factHeading.style.opacity = "0";
        factText.style.opacity = "0";

        setTimeout(() => {
            factHeading.innerText = facts[currentFactIndex].heading;
            factText.innerText = facts[currentFactIndex].text;

            factHeading.style.opacity = "1";
            factText.style.opacity = "1";

            currentFactIndex = (currentFactIndex + 1) % facts.length;
        }, 500); // Delay before changing text
      }

      setInterval(showFact, 10000);
      showFact(); // Show the first fact immediately
    </script>
 
 
    <div class="container signUpContainer" id="signUp" style="display:none;">
      <p class="form-title">Register</p>
      <form method="post" action="register.php">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="name" id="name" placeholder="Name" required>
           <label for="email">Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="signupPassword" placeholder="Password" required>
            <label for="email">Password</label>
            <span id="togglePassword" class="eye-icon">
            <i class="fas fa-eye"></i>
        </span>
        </div>
       <input type="submit" class="btn" value="Sign Up" name="signUp">
      </form>
      <div class="links">
        <p>Already Have Account ?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>

    <div class="container signInContainer" id="signIn">
        <p class="form-title">Sign In</p>
        <form method="post" action="login.php">
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Email" required>
              <label for="email">Email</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
              <span id="togglePassword" class="eye-icon">
                  <i class="fas fa-eye"></i>
              </span>
          </div>
          <p class="recover">
            <a href="forgot-password.php">Forgot Password?</a>
          </p>
         <input type="submit" class="btn" value="Sign In" name="signIn">
        
        </form>
        <div class="links" color="red">
          <p>Don't have an account yet?</p>
          <button id="signUpButton">Sign Up</button>
        </div>
      </div>

  </div>
</body>
</html>
