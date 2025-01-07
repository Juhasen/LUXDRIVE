<?php
require_once 'database.php';
function get_car_info_by_id($id)
{
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM Vehicles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    closeConnection($conn);

    return $result;
}

function get_user_details_by_id($id){
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT 
                                     isAdmin,
                                     name, 
                                     surname, 
                                     email, 
                                     phone_number, 
                                     country,
                                     city, 
                                     street, 
                                     apartment, 
                                     postal_code, 
                                     license_number 
                                   FROM Users 
                                   WHERE user_id = ?");

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    closeConnection($conn);
    return $result;
}

function check_if_user_is_admin($id){
    $conn = connectToDatabase();
    $user_id = $id;
    $stmt = $conn->prepare("SELECT isAdmin FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    closeConnection($conn);
    $user = $result->fetch_assoc();
    return $user['isAdmin'];
}

function delete_car($id): bool
{
    $conn = connectToDatabase();
    $stmt = $conn->prepare("DELETE FROM Vehicles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    closeConnection($conn);
    return $result;
}

function update_car($id, $make, $model, $year, $price, $seats, $gearbox, $luggage, $type, $odometer, $vin, $location, $last_service, $license_plate, $image): bool
{
    $conn = connectToDatabase();
    $stmt = $conn->prepare("UPDATE Vehicles SET make = ?, model = ?, year = ?, price = ?, seats = ?, gearbox_type = ?, luggage = ?, type = ?, odometer = ?, vin = ?, location = ?, last_service = ?, license_plate = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssiiisisisssssi", $make, $model, $year, $price, $seats, $gearbox, $luggage, $type, $odometer, $vin, $location, $last_service, $license_plate, $image, $id);
    $result = $stmt->execute();
    $stmt->close();
    closeConnection($conn);
    return $result;
}

function add_car($make, $model, $year, $price, $seats, $gearbox, $luggage, $type, $odometer, $vin, $location, $last_service, $license_plate, $image): bool
{
    $conn = connectToDatabase();
    $stmt = $conn->prepare("INSERT INTO Vehicles (make, model, year, price, seats, gearbox_type, luggage, type, odometer, vin, location, last_service, license_plate, image) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiisisisssss", $make, $model, $year, $price, $seats, $gearbox, $luggage, $type, $odometer, $vin, $location, $last_service, $license_plate, $image);
    $result = $stmt->execute();
    $stmt->close();
    closeConnection($conn);
    return $result;
}
