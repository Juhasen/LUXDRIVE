<?php

session_start();
require '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $car_id = intval($_POST['car_id']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Validate dates
    if (strtotime($start_date) >= strtotime($end_date)) {
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

    $stmt = $conn->prepare("INSERT INTO Rentals (user_id, car_id, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $car_id, $start_date, $end_date);

    if ($stmt->execute()) {
        echo "<p>Rezerwacja zakończona sukcesem!</p>";
    } else {
        echo "<p>Błąd podczas rezerwacji: " . $conn->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
