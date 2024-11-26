<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carType = $_POST['car_type'] ?? null;
    $pickUpLocation = $_POST['pick_up_location'] ?? null;
    $rentalDateStart = $_POST['rental_date_start'] ?? null;
    $dropOffLocation = $_POST['drop_off_location'] ?? null;
    $rentalDateEnd = $_POST['rental_date_end'] ?? null;

    echo "<pre>$carType</pre>";
    echo "<pre>$pickUpLocation</pre>";
    echo "<pre>$rentalDateStart</pre>";
    echo "<pre>$dropOffLocation</pre>";
    echo "<pre>$rentalDateEnd</pre>";


    if ($carType && $pickUpLocation && $rentalDateStart && $dropOffLocation && $rentalDateEnd) {
        if($rentalDateStart > $rentalDateEnd) {
            echo "End date must be after start date.";
            exit;
        }
        echo "Form submitted successfully!";
    } else {
        echo "Please fill in all fields.";
    }
}

