<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $vehicle_id = intval($_POST['vehicle_id']);
    $pickUpLocation = $_POST['pick_up_location'] ?? null;
    $rentalDateStart = $_POST['rental_date_start'] ?? null;
    $dropOffLocation = $_POST['drop_off_location'] ?? null;
    $rentalDateEnd = $_POST['rental_date_end'] ?? null;

    // Allowed locations
    $allowedLocations = ['Kraków', 'Warszawa', 'Gdańsk'];

    // Validate locations
    if (!in_array($pickUpLocation, $allowedLocations) || !in_array($dropOffLocation, $allowedLocations)) {
        echo "Invalid pick-up or drop-off location.";
        exit;
    }

//    // Debugging output (can be removed later)
//    echo "User ID: $user_id<br>";
//    echo "Vehicle ID: $vehicle_id<br>";
//    echo "Pick-up location: $pickUpLocation<br>";
//    echo "Rental date start: $rentalDateStart<br>";
//    echo "Drop-off location: $dropOffLocation<br>";
//    echo "Rental date end: $rentalDateEnd<br>";
//    sleep(5);

    if ($pickUpLocation && $rentalDateStart && $dropOffLocation && $rentalDateEnd) {
        if ($rentalDateStart > $rentalDateEnd) {
            echo "End date must be after start date.";
            exit;
        }
        echo "Form submitted successfully!";
    } else {
        echo "Please fill in all fields.";
    }

    // Validate dates
    if (strtotime($rentalDateStart) >= strtotime($rentalDateEnd)) {
        die("<p>Błąd: Data zakończenia musi być późniejsza niż data rozpoczęcia.</p>");
    }

    // Insert into the database
    $config = require '../config/database.php';
    $conn = new mysqli(
        $config['host'],
        $config['username'],
        $config['password'],
        $config['database']
    );

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO Rentals (user_id, vehicle_id, start_date, end_date, pick_up_location, drop_off_location) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $user_id, $vehicle_id, $rentalDateStart, $rentalDateEnd, $pickUpLocation, $dropOffLocation);

    if ($stmt->execute()) {
        header("Location: ../public/index.php?page=profile");
    } else {
        echo "<p>Błąd podczas rezerwacji: " . $conn->error . "</p>";
    }
//    sleep(5);
    $stmt->close();
    $conn->close();
}
