<?php
session_start();
include "connect.php";

// ✅ Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    die("User ID is missing. Check login status.");
}

$user_id = $_SESSION["user_id"];

// ✅ Debug: Check if form data is received
echo "<pre>";
print_r($_POST);
echo "</pre>";

// ✅ Ensure it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Household
    $household = 
        (isset($_POST['electricity']) ? floatval($_POST['electricity']) * 0.85 : 0) +
        (isset($_POST['naturalGas']) ? floatval($_POST['naturalGas']) * 2.2 : 0) +
        (isset($_POST['coal']) ? floatval($_POST['coal']) * 2.5 : 0) +
        (isset($_POST['lpg']) ? floatval($_POST['lpg']) * 1.5 : 0) +
        (isset($_POST['wood']) ? floatval($_POST['wood']) * 1.8 : 0);

    // Flights
    $flightDistance = isset($_POST['flightDistance']) ? floatval($_POST['flightDistance']) : 0;
    $flightType = isset($_POST['flightType']) ? $_POST['flightType'] : 'one-way';
    $flightFactor = ($flightType == 'return') ? 0.25 : 0.15;
    $flights = $flightDistance * $flightFactor;

    // Car
    $carMileage = isset($_POST['annualMileage']) ? floatval($_POST['annualMileage']) : 0;
    $carConsumption = isset($_POST['fuelEfficiency']) ? floatval($_POST['fuelEfficiency']) : 0;
    $carFuelType = $_POST['carFuel'] ?? 'Gasoline';
    $carFactors = ['Gasoline' => 2.31, 'Diesel' => 2.68, 'Hybrid' => 1.5, 'Electric' => 0];
    $car = ($carMileage / 100) * ($carFactors[$carFuelType] ?? 2.31) * $carConsumption;

    // Motorbike
    $motorbikeMileage = isset($_POST['motorbikeMileage']) ? floatval($_POST['motorbikeMileage']) : 0;
    $motorbikeConsumption = isset($_POST['motorbikeEfficiency']) ? floatval($_POST['motorbikeEfficiency']) : 0;
    $motorbikeFuelType = $_POST['motorbikeFuel'] ?? 'Gasoline';
    $motorbikeFactors = ['Gasoline' => 2.1, 'Electric' => 0];
    $motorbike = ($motorbikeMileage / 100) * ($motorbikeFactors[$motorbikeFuelType] ?? 2.1) * $motorbikeConsumption;

    // Public Transport
    $publicTransport = 
        (isset($_POST['train']) ? floatval($_POST['train']) * 0.05 : 0) +
        (isset($_POST['cityBus']) ? floatval($_POST['cityBus']) * 0.08 : 0) +
        (isset($_POST['stateBus']) ? floatval($_POST['stateBus']) * 0.1 : 0);

    // Lifestyle
    $lifestyle = max(0, 
    (isset($_POST['expenditure']) ? floatval($_POST['expenditure']) * 0.12 : 0) +
    (($_POST['diet'] ?? 'meat-most') == 'vegan' ? -50 : (($_POST['diet'] ?? 'meat-most') == 'vegetarian' ? -30 : 0)) +
    (($_POST['localProducts'] ?? 'never') == 'always' ? -10 : 0) +
    (($_POST['responsibleCompanies'] ?? 'never') == 'always' ? -5 : 0)
        );


    // ✅ Store in session for results.php
    $_SESSION['latest_results'] = [
        "household" => round($household, 2),
        "flights" => round($flights, 2),
        "car" => round($car, 2),
        "motorbike" => round($motorbike, 2),
        "publicTransport" => round($publicTransport, 2),
        "lifestyle" => round($lifestyle, 2)
    ];

    // ✅ Store in database
    $stmt = $conn->prepare("INSERT INTO emissions (user_id, household, flights, car, motorbike, publicTransport, lifestyle) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("idddddd", $user_id, $household, $flights, $car, $motorbike, $publicTransport, $lifestyle);

    // ✅ Debug: Check if the query executes successfully
    if (!$stmt->execute()) {
        die("Database Insert Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    // ✅ Redirect to results.php
    header("Location: results.php");
    exit();
}
?>
