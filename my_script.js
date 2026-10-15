
const signUpButton = document.getElementById('signUpButton');
const signInButton = document.getElementById('signInButton');
const signUpContainer = document.getElementById('signUp');
const signInContainer = document.getElementById('signIn');

// Add click event listener for the "Sign Up" button
signUpButton.addEventListener('click', () => {
  signInContainer.style.display = 'none';
  signUpContainer.style.display = 'block';
});

// Add click event listener for the "Sign In" button
signInButton.addEventListener('click', () => {
  signUpContainer.style.display = 'none';
  signInContainer.style.display = 'block';
});
document.addEventListener("DOMContentLoaded", function () {
  function checkFormExistence() {
      const signUpForm = document.getElementById("signUp");


      console.log("✅ Sign-up form found!");
      setupValidation(signUpForm);
  }

  function setupValidation(signUpForm) {
      const passwordInput = document.getElementById("signupPassword");

      if (!passwordInput) {
          console.error("❌ Error: Password input field not found!");
          return;
      }

      signUpForm.addEventListener("submit", function (event) {
          
          const passwordValue = passwordInput.value;
        
          if (!validatePassword(passwordValue)) {
              event.preventDefault();
              alert("Password must contain:\n• At least 8 characters\n• One uppercase letter\n• One lowercase letter\n• One number\n• One special character (@, $, etc.)");
          } else {
              console.log("✅ Password is valid, form will be submitted.");
              alert("User Registered.");
          }
      });
  }

  function validatePassword(password) {
      return (
          password.length >= 8 &&
          /[A-Z]/.test(password) &&
          /[a-z]/.test(password) &&
          /\d/.test(password) &&
          /[@$!%*?&]/.test(password)
      );
  }

  checkFormExistence();
});
document.addEventListener("DOMContentLoaded", function () {
  const toggleIcons = document.querySelectorAll("#togglePassword"); // Select all eye icons
  const passwordInputs = document.querySelectorAll("input[type='password']"); // Select all password fields

  toggleIcons.forEach((icon, index) => {
      icon.addEventListener("click", function () {
          if (passwordInputs[index].type === "password") {
              passwordInputs[index].type = "text";  // Show password
              icon.innerHTML = '<i class="fas fa-eye-slash"></i>';
          } else {
              passwordInputs[index].type = "password";  // Hide password
              icon.innerHTML = '<i class="fas fa-eye"></i>';
          }
      });
  });
});







