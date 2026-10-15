<header id="header">
    <nav class="header-nav">
        <a href="index.html">Home<span></span></a>
        <a href="calculator.html">Calculator<span></span></a>
        <!-- <a href="#About">About Us<span></span></a> -->
        <!-- <a href="#Footer">Contact<span></span></a> -->
        <!-- <a href="login-form.php">Sign Up<span></span></a> -->
        <a href="results.php">Emissions</a>
        <a href="category.html">Actions</a>
        <a href="projectdone/home.php">Eco Shop<span></span></a>
    </nav>
    <div id="user-btn" onclick="toggleMenu()">
        <i class="fas fa-user"></i>
    </div>
    <div class="dropdown" id="dropdownMenu">
        <ul class="menu-content">
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    </div>
        
</header>

<style>
    .header-nav {
        width: 100vw;
        height: 100px;
        background: black;
        color: white;
        display: flex; /* Ensures items are visible */
        align-items: center; /* Align items vertically */
        justify-content: space-around; /* Space them evenly */
        padding: 0 20px;
    }
    body, html {
        margin: 0;
        padding: 0;
    }
    .header-nav {
        position: fixed; /* Ensures it's always visible */
        top: 0;
        left: 0;
        z-index: 1000; /* Makes sure it's above everything else */
    }



    .header-nav a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        font-weight: bold;
    }

    .header-nav a:hover {
        color: lightgray;
    }

    #user-btn i {
            font-size: 24px;   /* Adjust size */
            color: white;      /* Ensure it's visible */
            cursor: pointer;  
            display: inline-block;
            padding: 10px;
        }
        .dropdown {
            display: none;
            position: absolute;
            right: 20px;
            top: 60px;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            /* border-radius: 5px; */
            width: 180px;
        }
        .dropdown ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .dropdown ul li {
            padding: 12px;
            cursor: pointer;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        .dropdown ul li:last-child {
            border-bottom: none;
        }
        .dropdown ul li:hover {
            background: #f1f1f1;
        }
</style>
<script>
        // function toggleMenu() {
        //     var menu = document.getElementById("dropdownMenu");
        //     menu.style.display = (menu.style.display === "block") ? "none" : "block";
        // }
        function toggleMenu() {
            var menu = document.getElementById("dropdownMenu");
            console.log("Toggling menu. Current state:", menu.style.display);
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }
    </script>