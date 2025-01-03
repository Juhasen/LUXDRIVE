<?php

function connectToDatabase()
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

    return $conn;
}

function closeConnection($conn)
{
    $conn->close();
}

function getCarInfoByID($ID)
{
    $conn = connectToDatabase();

    $sql = "SELECT * FROM Vehicles WHERE id = $ID";

    $result = $conn->query($sql);

    closeConnection($conn);

    return $result;
}