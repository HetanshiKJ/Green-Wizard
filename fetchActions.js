function fetchActions() {
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get("category") || "Default Category";

    // Prevent caching issues by appending a timestamp
    const url = `get_actions.php?category=${encodeURIComponent(category)}&t=${new Date().getTime()}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log("Fetched actions:", data); // Debugging output

            let actionList = document.getElementById("action_list");
            actionList.innerHTML = "";

            if (!data || data.length === 0) {
                console.warn("No actions found in the database.");
                actionList.innerHTML = `<li>No actions found.</li>`;
                return;
            }

            data.forEach(action => {
                let listItem = document.createElement("li");
                listItem.innerHTML = `
                    <div class="action-content">
                        <div class="action_name">
                            <h3>${action.name}</h3>
                        </div>
                        
                        <div class="description">${action.description}</div>
                        <p class="earth-points"><strong>Earth Points:</strong> ${action.impact_score}</p>
                    </div>
                    <button class="add-btn" data-action-id="${action.id}">+</button>
                `;
                actionList.appendChild(listItem);
            });

            // Attach event listeners to the buttons
            document.querySelectorAll(".add-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let actionId = this.getAttribute("data-action-id");
                    console.log("User selected action ID:", actionId);
                    selectAction(actionId);
                });
            });
        })
        .catch(error => console.error("Error fetching actions:", error));
}

// Function to send selected action to the backend
function selectAction(actionId) {
    console.log("Sending action ID:", actionId);

    fetch("save_action.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "action_id=" + encodeURIComponent(actionId)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Response from server:", data);
        alert(data.message);
    })
    .catch(error => console.error("Error selecting action:", error));
}

// Ensure fetchActions is called after DOM is loaded
document.addEventListener("DOMContentLoaded", fetchActions);

