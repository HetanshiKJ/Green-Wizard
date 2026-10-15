gsap.fromTo(
    ".loading-page",
    { opacity: 0.8 },
    {
      opacity: 1,
      display: "none",
      duration: 0.1,
      delay: 1,
      onComplete: function() {
        document.querySelector('.loading-page').style.display = 'none'; // Hide after animation
      },
    }
  );
  
  gsap.fromTo(
    ".container", 
    {
      y: 100,
      opacity: 0,
    },
    {
      y: 0,
      opacity: 1,
      duration: 1.2,
      delay: 0.7,
    }
  );
  
  gsap.fromTo(
    ".nav",
    { 
      y: 100,
      opacity: 0 
    },
    { 
      y: 0,
      opacity: 1, 
      duration: 1.5, 
      delay: 1 
    }
  );

  gsap.fromTo(
    ".logo",
    { 
      opacity: 0,
      y: 100
    },
    
    { 
      y: 0,
      opacity: 1, 
      duration: 1.5, 
      delay: 1 
    }
  );
