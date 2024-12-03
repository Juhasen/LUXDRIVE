<?php
session_start();
$_SESSION['valid']= true;
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

$email = $_POST['email'];
$password = $_POST['password'];


$stmt = $conn->prepare("SELECT user_id, name, password FROM Users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $name, $hashed_password);
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        // Store user information in session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;

        header("Location: http://localhost:63342/LUXDRIVE/public/index.php?page=profile");
        exit;
    } else {
        echo "<h1>Invalid username or password!</h1>";
    }
} else {
    echo "<h1>User not found!</h1>";
}

$stmt->close();
$conn->close();
