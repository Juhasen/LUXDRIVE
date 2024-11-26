<?php

session_start();
$_SESSION['valid']= true;

$config = require '/opt/lampp/htdocs/IAB/config/database.php';

$conn = new mysqli(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database']
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validate input
if (empty($name) || empty($email) || empty($password)) {
    die("<h1>All fields are required!</h1>");
}

// Check if the email already exists
$stmt = $conn->prepare("SELECT user_id FROM Users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<h1>Email is already registered!</h1>";
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user
$stmt = $conn->prepare("INSERT INTO Users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['user_id'] = $stmt->insert_id;  // The user_id generated by the INSERT statement
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;

    // Redirect to the user profile page
    header("Location: http://localhost:63342/IAB/public/index.php?page=profile");
    exit;
} else {
    echo "<h1>Registration failed. Please try again.</h1>";
}

$stmt->close();
$conn->close();
