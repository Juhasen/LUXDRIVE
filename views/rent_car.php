<?php
session_start();
require '../config/database.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']); // Assuming `user_id` is set in the session on login

// Connect to the database
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

// Fetch car details using car_id
$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 0;
$sql = "SELECT * FROM Vehicles WHERE id = $car_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("<p>Samochód nie został znaleziony.</p>");
}

$car = $result->fetch_assoc();
$gearbox = $car['gearbox_type'] == 2 ? 'Automat' : 'Manual';
$conn->close();
?>


<div class="rent-car-container">
    <div class="car-card">
        <img src="../public/assets/images/<?php echo htmlspecialchars($car['image']); ?>"
             alt="<?php echo htmlspecialchars($car['make']); ?>" class="car-image"/>
        <div class="car-info">
            <div class="car-specs">
                <h2 class="car-name"><?php echo htmlspecialchars($car['make']) . ' ' . htmlspecialchars($car['model']); ?></h2>
                <div class="car-details">
                        <span class="detail-icon">
                            <img src="../public/assets/icons/car-seat.png" alt="Seats"> <?php echo htmlspecialchars($car['seats']); ?>
                        </span>
                    <span class="detail-icon">
                            <img src="../public/assets/icons/gearbox.png" alt="Gearbox"> <?php echo htmlspecialchars($gearbox); ?>
                        </span>
                    <span class="detail-icon">
                            <img src="../public/assets/icons/luggage.png" alt="Luggage"> <?php echo htmlspecialchars($car['luggage']); ?>
                        </span>
                    <span class="detail-icon">
                            <img src="../public/assets/icons/calendar.png" alt="Year"> <?php echo htmlspecialchars($car['year']); ?>
                        </span>
                </div>
            </div>
            <div class="car-price">
                <span class="price"><?php echo number_format($car['price'], 0); ?>zł <small>/Doba</small></span>
            </div>
        </div>
    </div>

    <?php if (!$isLoggedIn): ?>
        <!-- Show login prompt -->
        <div class="login-prompt">
            <p>Musisz się zalogować, aby wypożyczyć samochód.</p>
            <a href="login.php" class="primary-button">Przejdź do logowania</a>
        </div>
    <?php else: ?>
        <!-- Show user data and form -->
        <div class="user-data">
            <h3>Twoje dane</h3>
            <p>Imię: <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
        </div>

        <div class="rental-form">
            <h3>Formularz rezerwacji</h3>
            <form action="process_rental.php" method="POST">
                <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                <label for="start_date">Data rozpoczęcia:</label>
                <input type="date" name="start_date" id="start_date" required>

                <label for="end_date">Data zakończenia:</label>
                <input type="date" name="end_date" id="end_date" required>

                <button type="submit" class="primary-button">Potwierdź rezerwację</button>
            </form>
        </div>
    <?php endif; ?>
</div>