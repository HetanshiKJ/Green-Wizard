<?php

session_start();
include "connect.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login-form.php");
    exit();
}

$userId = $_SESSION['user_id']; // Get the logged-in user ID

// Fetch the latest emissions for the logged-in user
$query = "SELECT household, flights, car, motorbike, publicTransport, lifestyle FROM emissions WHERE user_id = ? ORDER BY recorded_at DESC LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$results = [];

if ($row) {
    // Store the emissions correctly
    $results = [
        "household" => $row['household'],
        "flights" => $row['flights'],
        "car" => $row['car'],
        "motorbike" => $row['motorbike'],
        "publicTransport" => $row['publicTransport'],
        "lifestyle" => $row['lifestyle']
    ];
}

// If no emissions found, redirect to calculator
if (empty($results)) {
    header("Location: calculator.html");
    exit();
}
$totalEmissions = array_sum($results);
$categories = json_encode(array_keys($results), JSON_UNESCAPED_SLASHES);
$values = json_encode(array_values($results), JSON_NUMERIC_CHECK);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Carbon Footprint Report</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            /* background-color: #f4f7f6; */
            background-image: linear-gradient(25deg,rgb(230, 238, 215), rgb(243, 245, 240));
            color: #333;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #4D6541;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .report-container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        /* .result-grid{
            max-width: 900px;
            margin: auto 0px;
            background: white;
            padding: 20px;
            border-radius: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        } */

        .chart-container {
            width: 100%;
            max-width: 500px;
            margin: auto;
            padding: 15px;
        }

        .total-emission {
            font-size: 1.5rem;
            width: 600px;
            color:rgb(63, 62, 62);
            margin: 0 auto;
            margin-top: 40px;
            padding: 15px;
            background: #ffe6e6;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        /*  Horizontal block styling */
        .result-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            padding: 20px 0;
            margin: 40px;
        }

        .result-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            width: 180px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease-in-out;
        }

        .result-item:hover {
            transform: scale(1.05);
        }

        .icon img {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
        }

        .category-name {
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
            text-align: center;
        }

        .carbon-value {
            font-size: 1rem;
            font-weight: bold;
            color:rgb(127, 161, 112);
        }

        .buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .button {
            padding: 12px 20px;
            background: #4D6541;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            transition: background 0.3s ease-in-out;
            margin: 30px;
            margin-bottom: 50px;
        }

        .button:hover {
            background: #3a4c30;
        }
        .heading{
            font-family: "Manrope";
            font-size: 40px;
            color: black;
        }

        @media (max-width: 768px) {
            .result-grid {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

    <p class="heading">Your Carbon Footprint Report</p>

    <div class="report-container">
        <!--  Display Pie Chart for Category-wise Breakdown -->
        <div class="chart-container">
            <canvas id="emissionsChart"></canvas>
        </div>

        <!--  Display Total Carbon Footprint -->
        <div class="total-emission">
             <strong>Total Carbon Footprint:</strong> <?= number_format($totalEmissions, 2) ?> kg CO₂
        </div>

    </div>

        <!--  Display Category-wise Breakdown in Horizontal Blocks -->
    <div class="result-grid">
        <?php
        $categoryImages = [
            "household" => 'Images/home.png',
            "flights" => 'Images/plane (2).png',
            "car" => 'Images/car.png',
            "motorbike" => 'Images/motorcycle.png',
            "publicTransport" => 'Images/bus.png',
            "lifestyle" => 'Images/planting.png'
        ];

        foreach ($results as $category => $value): ?>
            <div class="result-item">
                <span class="icon">
                    <img src="<?= $categoryImages[$category] ?? 'Images/house.png' ?>" alt="<?= ucfirst($category) ?>">
                </span>
                <span class="category-name"><?= ucfirst($category) ?></span>
                <span class="carbon-value"><?= number_format($value, 2) ?> kg CO₂</span>
            </div>
        <?php endforeach; ?>
    </div>
    

    <div class="buttons">
        <a href="my_emissions.php" class="button"> View My Past Carbon Emissions</a>
        <a href="calculator.html" class="button"> Calculate Again</a>
    </div>

    <script>
    console.log("Categories:", <?= $categories ?>);
    console.log("Values:", <?= $values ?>);

    const categories = <?= $categories ?>;
    const values = <?= $values ?>;

    // Ensure data is not empty before rendering chart
    if (categories.length > 0 && values.length > 0) {
        const ctx = document.getElementById('emissionsChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Carbon Footprint (kg CO₂)',
                    data: values,
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#9966ff', '#ff9f40'],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { size: 14 } }
                    }
                }
            }
        });
    } else {
        console.warn("No data available for chart.");
    }
</script>


</body>
</html>
