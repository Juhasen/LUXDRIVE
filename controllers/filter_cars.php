<?php

function getFilteredCars($filters)
{
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

    // Base SQL query
    $sql = "SELECT * FROM Vehicles WHERE 1=1";

    // Apply filters
    if (isset($filters['gearbox']) && $filters['gearbox'] !== "") {
        $gearbox = intval($filters['gearbox']);
        $sql .= " AND gearbox_type = $gearbox";
    }

    if (isset($filters['seats']) && $filters['seats'] !== "") {
        $seats = intval($filters['seats']);
        $sql .= " AND seats >= $seats";
    }

    if (isset($filters['price']) && $filters['price'] !== "") {
        $price = intval($filters['price']);
        $sql .= " AND price <= $price";
    }

    if(isset($filters['car_type']) && $filters['car_type'] !== "") {
        $car_type = $filters['car_type'];
        $sql .= " AND type = '$car_type'";
    }
    echo $sql;
    $result = $conn->query($sql);

    $conn->close();

    return $result;
}
