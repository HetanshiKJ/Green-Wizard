<?php
session_start();
include "connect.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM emissions WHERE user_id = ? ORDER BY recorded_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Past Emissions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 20px;
            text-align: center;
            background: linear-gradient(25deg,rgb(230, 238, 215), rgb(243, 245, 240));
            background-repeat: no-repeat;
            /* background-size: cover; */
            width: 100%;
            height: 100vh;
        }

        .heading {
            font-family: "Manrope";
            font-size: 40px;
            margin-bottom: 20px;
        }

        table {
            width: 70%;
            margin: 0 auto;
            border-collapse: separate;
            border-spacing: 0; 
            margin-top: 50px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background: #4D6541;
            color: white;
        }
        tr{
            background-color:whitesmoke;
        }

        /* tr:hover {
            background: #e9f5e9;
            transition: 0.3s;
        } */

        .back-button {
            display: inline-block;
            margin-top: 50px;
            padding: 12px 20px;
            background: #4D6541;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            transition: background 0.3s ease-in-out;
        }

        .back-button:hover {
            background: black;
        }
        
    </style>
</head>
<body>
    <p class="heading">Past Emissions</p>
    
    <div class="table-container">
        <table cellspacing="0">
            <tr>
                <th>Date</th>
                <th>Household</th>
                <th>Flights</th>
                <th>Car</th>
                <th>Motorbike</th>
                <th>Public Transport</th>
                <th>Lifestyle</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["recorded_at"] ?></td>
                    <td><?= $row["household"] ?> kg CO₂</td>
                    <td><?= $row["flights"] ?> kg CO₂</td>
                    <td><?= $row["car"] ?> kg CO₂</td>
                    <td><?= $row["motorbike"] ?> kg CO₂</td>
                    <td><?= $row["publicTransport"] ?> kg CO₂</td>
                    <td><?= $row["lifestyle"] ?> kg CO₂</td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <a href="calculator.html" class="back-button">Calculate Emissions</a>
</body>
</html>

