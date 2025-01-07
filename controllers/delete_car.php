<?php

require_once 'functions.php';
require_once 'constants.php';
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || check_if_user_is_admin($_SESSION['user_id']) != 'yes') {
    header("Location: " . BASE_REDIRECT_URL . "home");
    exit;
}

if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Fetch car details to get the image file name
    $car = get_car_info_by_id($car_id); // Assuming you have a function to fetch car details

    if ($car) {
        $target_dir = '../public/assets/images/';
        if (file_exists($target_dir . $car['image'])) {
            unlink($target_dir . $car['image']);
        }

        $result = delete_car($car_id);

        if ($result) {
            header("Location: " . BASE_REDIRECT_URL . "admin&message=Car deleted successfully.");
        } else {
            echo "Błąd podczas usuwania samochodu.";
        }
    } else {
        echo "Nie znaleziono samochodu.";
    }
} else {
    echo "Niepoprawne ID samochodu.";
}

