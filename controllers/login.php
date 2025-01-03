<?php
require_once '../controllers/constants.php';
require_once '../controllers/database.php';

session_start();
$_SESSION['valid']= true;

$conn = connectToDatabase();

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

        header("Location: " . BASE_REDIRECT_URL . 'profile');
        exit;
    } else {
        echo "<h1>Invalid username or password!</h1>";
    }
} else {
    echo "<h1>User not found!</h1>";
}

$stmt->close();
closeConnection($conn);
