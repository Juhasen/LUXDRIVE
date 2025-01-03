<?php
require_once 'database.php';
function getCarInfoByID($ID)
{
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM Vehicles WHERE id = ?");

    $stmt->bind_param("i", $ID);

    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    closeConnection($conn);

    return $result;
}