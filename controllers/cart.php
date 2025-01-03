<?php
session_start();

// Initialize the cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleId = $_POST['vehicle_id'] ?? '';
    $pickUpLocation = $_POST['pick_up_location'] ?? '';
    $dropOffLocation = $_POST['drop_off_location'] ?? '';
    $rentalDateStart = $_POST['rental_date_start'] ?? '';
    $rentalDateEnd = $_POST['rental_date_end'] ?? '';

    if ($vehicleId && $pickUpLocation && $dropOffLocation && $rentalDateStart && $rentalDateEnd) {
        $_SESSION['cart'][] = [
            'vehicleId' => $vehicleId,
            'pickUpLocation' => $pickUpLocation,
            'dropOffLocation' => $dropOffLocation,
            'rentalDateStart' => $rentalDateStart,
            'rentalDateEnd' => $rentalDateEnd,
        ];
    }
}

// Redirect back to the cart or relevant page
header('Location: ../public/index.php?page=cart');
exit;
