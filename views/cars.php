<?php
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

$sql = "SELECT * FROM Vehicles";
$result = $conn->query($sql);

$conn->close();
?>


<section class="main-container">
    <div class="cars-container">
       <?php
        require_once('/opt/lampp/htdocs/IAB/controllers/functions.php');
        generateCarCards($result);
        ?>
    </div>

</section>
