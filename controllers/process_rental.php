<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $cart = $_SESSION['cart'];

    // Allowed locations
    $allowedLocations = ['Kraków', 'Warszawa', 'Gdańsk'];

    // Check if the cart is empty
    if (empty($cart)) {
        echo "Your cart is empty.";
        exit;
    }

    // Initialize total cost
    $total_cost = 0;

    // Connect to the database
    $conn = connectToDatabase();


    // Add this vehicle's cost to the total
    $total_cost = $_SESSION['totalCost'] ?? 0;


    // Validate and process each vehicle in the cart
    foreach ($cart as $index => $item) {
        $vehicle_id = $item['vehicleId'];
        $pickUpLocation = $item['pickUpLocation'] ?? null;
        $rentalDateStart = $item['rentalDateStart'] ?? null;
        $dropOffLocation = $item['dropOffLocation'] ?? null;
        $rentalDateEnd = $item['rentalDateEnd'] ?? null;


        // Validate locations
        if (!in_array($pickUpLocation, $allowedLocations) || !in_array($dropOffLocation, $allowedLocations)) {
            echo "Invalid pick-up or drop-off location.";
            exit;
        }

        // Validate dates
        if (strtotime($rentalDateStart) >= strtotime($rentalDateEnd)) {
            die("<p>Błąd: Data zakończenia musi być późniejsza niż data rozpoczęcia.</p>");
        }

        // Prepare the rental query
        $stmt = $conn->prepare("INSERT INTO Rentals (user_id, vehicle_id, start_date, end_date, pick_up_location, drop_off_location) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $user_id, $vehicle_id, $rentalDateStart, $rentalDateEnd, $pickUpLocation, $dropOffLocation);

        // Execute the rental query
        if (!$stmt->execute()) {
            echo "Error processing rental for vehicle ID $vehicle_id: " . $stmt->error . "<br>";
            exit;
        }

        // After rental, get the rental_id
        $rental_id = $conn->insert_id;

        // Add selected services for this rental
        if (isset($item['options']) && is_array($item['options'])) {
            foreach ($item['options'] as $service_id) {
                // Prepare the query to insert into rental_services
                $serviceStmt = $conn->prepare("INSERT INTO rental_services (rental_id, service_id) VALUES (?, ?)");
                $serviceStmt->bind_param("ii", $rental_id, $service_id);

                // Execute the query to add the service to the rental
                if (!$serviceStmt->execute()) {
                    echo "Error adding service ID $service_id to rental ID $rental_id: " . $serviceStmt->error . "<br>";
                }
            }
        }
    }

    // After processing all vehicles, insert a single payment record
    $paymentStmt = $conn->prepare("INSERT INTO payments (rental_id, total_cost) VALUES (?, ?)");
    $paymentStmt->bind_param("id", $rental_id, $total_cost);

    // Execute the payment query
    if ($paymentStmt->execute()) {
        echo "Payment of $total_cost processed successfully!<br>";
    } else {
        echo "Error processing payment: " . $paymentStmt->error . "<br>";
    }

    closeConnection($conn);

    unset($_SESSION['cart']);
    unset($_SESSION['totalCost']);

    header("Location: https://luxdrive.pl/public/index.php?page=profile");
}

