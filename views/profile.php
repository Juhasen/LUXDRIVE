<?php

session_start();
$_SESSION['valid']= true;
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost:63342/LUXDRIVE/public/index.php?page=home");
    exit;
}

$user_name = $_SESSION['user_name'];
echo '<pre>';
print_r($_SESSION);  // To check if session variables are set correctly
echo '</pre>';
?>

<div class="main-container">
    <div class="profile-container">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
    </div>
    <form action="../controllers/logout.php" method="POST">
        <button type="submit" class="logout-button primary-button">Wyloguj</button>
    </form>
</div>
