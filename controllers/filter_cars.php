<?php

require_once 'database.php';

function get_filtered_cars($filters)
{
    $conn = connectToDatabase();

    // Base SQL query
    $sql = "SELECT * FROM Vehicles WHERE 1=1";

    // Prioritize car_id filter
    if (isset($filters['car_id']) && $filters['car_id'] !== "") {
        $car_id = intval($filters['car_id']);
        $sql .= " AND id = $car_id";
    } else {
        // Apply other filters
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

        if (isset($filters['car_type']) && $filters['car_type'] !== "") {
            $car_type = $conn->real_escape_string($filters['car_type']);
            $sql .= " AND type = '$car_type'";
        }
    }

    $result = $conn->query($sql);

    closeConnection($conn);

    return $result;
}

