<?php
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

$sql = "SELECT * FROM Vehicles";
$result = $conn->query($sql);

$conn->close();
?>


<section class="main-container">
    <div class="cars-container">
       <?php
       if ($result->num_rows > 0) {
           while ($row = $result->fetch_assoc()) {
               $gearbox = $row['gearbox_type'] == 1 ? 'Automat' : 'Manual';

               echo '
                <div class="car-card">
                    <img src="../public/assets/images/' . htmlspecialchars($row['image']) . '"
                         alt="' . htmlspecialchars($row['make']) . '" class="car-image"/>
                    <div class="car-info-page">
                        <div class="car-specs">
                            <h2 class="car-name">' . htmlspecialchars($row['make']) . ' ' . htmlspecialchars($row['model']) . '</h2>
                            <div class="car-details">
                                <span class="detail-icon">
                                    <img src="../public/assets/icons/car-seat.png" alt="Seats"> ' . htmlspecialchars($row['seats']) . '
                                </span>
                                <span class="detail-icon">
                                    <img src="../public/assets/icons/gearbox.png" alt="Gearbox"> ' . htmlspecialchars($gearbox) . '
                                </span>
                                <span class="detail-icon">
                                    <img src="../public/assets/icons/luggage.png" alt="Luggage"> ' . htmlspecialchars($row['luggage']) . '
                                </span>
                                <span class="detail-icon">
                                    <img src="../public/assets/icons/calendar.png" alt="Year"> ' . htmlspecialchars($row['year']) . '
                                </span>
                            </div>
                        </div>
                        <div class="car-price">
                            <span class="price">' . number_format($row['price'], 0) . 'zł <small>/Doba</small></span>
                            <button class="primary-button"><img src="../public/assets/icons/car-key.png" alt="car key" height="50" width="50"></button>
                        </div>
                    </div>
                </div>
                ';
           }
       } else {
           echo '<p>No cars available.</p>';
       }
        ?>
    </div>

</section>
