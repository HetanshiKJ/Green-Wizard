<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
     
        /* General Styling */
        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            background-image: linear-gradient(25deg,rgb(230, 238, 215), rgb(243, 245, 240));
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }
  

        /* Navbar */
        nav {
            width: 100%;
            background: #4d6641;
            padding: 15px 0;
            display: flex;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
        }

        nav button {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            margin: 0 15px;
            cursor: pointer;
            padding: 10px 15px;
            transition: background 0.3s;
        }

        nav button:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
       
        /* Main Container */
        .container {
            width: 60vw;
            height: 70vh;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;  /* Centers content horizontally */
            justify-content: flex-start;  /* Keeps content aligned at the top */
        }


        h1 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            text-align: center;
            width: 100%;
            /* background-color: yellow; */
        }


        #search {
            margin: 50px 0;
            padding: 10px;
            width: 500px;
            border-radius: 10px;
            border: 1px solid rgb(61, 61, 61);
            font-size: 16px;
        }
       
        /* Categories */
        .categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 40px;
        }

        .category {
            background: #f0f7e2;
            border: 2px solid #4d6641;
            border-radius: 10px;
            padding: 20px;
            transition: background 0.3s, transform 0.3s;
            cursor: pointer;
            font-size: 1.2rem;
            text-align: center;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items:center ;
        }

        .category:hover {
            background: #4d6641;
            color: #fff;
            transform: translateY(-5px);
        }

        .category a {
            display: block;
            width: 100%;
            height: 100%;
            color: inherit;
            text-decoration: none;
        }

        /* Sections */
        .section {
            display: none; /* Ensures only active section is visible */
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Centers content vertically */
            /* min-height: 60vh; Adjust as needed */
            width: 80%;
        }
        
        #myActionsSection.active {
            display: flex; /* Only the active section is displayed */
        }

        #browseActionsSection.active {
            display: block;
        }

        /* Action List */
        .action-list li {
            background: whitesmoke;
            margin: 10px 0;
            padding: 20px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid #4d6641;  
            margin-top: 20px;
            width: 500px;
            align-self: center;
        }

        .completed {
            background: #eff5f0;
            text-decoration: line-through;
        }
     

        .action-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
            width: 100%;
        }

    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            showSection("browseActionsSection");
        });

        function showSection(sectionId) {
            document.getElementById("browseActionsSection").classList.remove("active");
            document.getElementById("myActionsSection").classList.remove("active");
            document.getElementById(sectionId).classList.add("active");

            if (sectionId === "myActionsSection") {
                fetchUserActions();
            }
        }

        function fetchUserActions() {
            fetch("get_user_actions.php")
                .then(response => response.json())
                .then(data => {
                    console.log("Fetched Actions:", data); // Debugging log

                    let actionList = document.getElementById("my_action_list");
                    actionList.innerHTML = ""; // Clear existing actions

                    if (data.length === 0) {
                        actionList.innerHTML = `<li>No actions found.</li>`;
                        return;
                    }

                    data.forEach(action => {
                        let listItem = document.createElement("li");
                        listItem.classList.add("my_action_li");

                        // Apply "completed" style if status is completed
                        if (action.status === "completed") {
                            listItem.classList.add("completed");
                        }

                        listItem.innerHTML = `
                            <span>${action.name}</span>
                            <input type="checkbox" class="action-checkbox" 
                                data-action-id="${action.id}" 
                                ${action.status === "completed" ? "checked" : ""}
                                onclick="toggleActionStatus(${action.id}, this)">
                        `;

                        actionList.appendChild(listItem);
                    });
                })
                .catch(error => console.error("Error fetching user actions:", error));
        }

        function toggleActionStatus(actionId, checkbox) {
            let newStatus = checkbox.checked ? "completed" : "pending";

            fetch("update_action_status.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action_id: actionId, status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let listItem = checkbox.parentElement;
                    listItem.classList.toggle("completed", newStatus === "completed");
                } else {
                    console.error("Error updating status:", data.message);
                    checkbox.checked = !checkbox.checked; // Revert if there's an error
                }
            })
            .catch(error => console.error("Error:", error));
        }
        // function toggleMenu() {
        //     var menu = document.getElementById("dropdownMenu");
        //     console.log("Toggling menu. Current state:", menu.style.display);
        //     menu.style.display = (menu.style.display === "block") ? "none" : "block";
        // }
    </script>

</head>
<body>

  

    <!-- Navigation Bar -->
    <nav>
        <button onclick="showSection('browseActionsSection')">Browse Actions</button>
        <button onclick="showSection('myActionsSection')">My Actions</button>
        
        </nav>
    
    

    <!-- Main Container -->
    <div class="container">
        
        
        <!-- Browse Actions Section -->
        <div id="browseActionsSection" class="section active">
            <h1>Categories</h1>
            <input type="text" id="search" placeholder="Search categories...">
            <div class="categories" id="categoryList">
                <div class="category"><a href="category-advocacy-choice.php?category=Advocacy and Choices">Advocacy and Choice</a></div>
                <div class="category"><a href="category-family-community.php?category=Family and Community">Family and Community</a></div>
                <div class="category"><a href="category-home-work.php?category=Home and Work">Home and Work</a></div>
                <div class="category"><a href="category-energy.php?category=Energy">Energy</a></div>
                <div class="category"><a href="category-food.php?category=Food">Food</a></div>
                <div class="category"><a href="category-transportation-travel.php?category=Transportation and Travel">Transport and Travel</a></div>
            </div>
        </div>

        <!-- My Actions Section -->
        <div id="myActionsSection" class="section">
            <h1>My Actions</h1>
            <ul id="my_action_list" class="action-list"></ul>
        </div>
    </div>

</body>
</html>

