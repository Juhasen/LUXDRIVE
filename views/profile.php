<?php
require '../controllers/functions.php';
require_once '../controllers/constants.php';
session_start();
$_SESSION['valid'] = true;

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_REDIRECT_URL . "home");
    exit;
}

$conn = connectToDatabase();

$user_id = $_SESSION['user_id'];

// Get user details
$stmt = $conn->prepare("SELECT * FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Get rentals with vehicle details
$stmt = $conn->prepare("SELECT Rentals.*, Vehicles.make AS vehicle_name, Vehicles.model AS vehicle_model , Vehicles.image AS vehicle_photo 
                        FROM Rentals 
                        JOIN Vehicles ON Rentals.vehicle_id = Vehicles.id 
                        WHERE Rentals.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$rental_result = $stmt->get_result();
$stmt->close();
closeConnection($conn);
?>

<div class="main-container">
    <div class="profile-container">
        <h1>Witaj, <span class="highlight"><?php echo htmlspecialchars($user['name']); ?></span>!</h1>
        <div class="user-data">
            <h3>TWOJE DANE</h3>
            <div class="data-container">
                <div class="labels">
                    <p>Imię:</p>
                    <p>Nazwisko:</p>
                    <p>Email:</p>
                    <p>Telefon:</p>
                    <p>Kraj:</p>
                    <p>Miasto:</p>
                    <p>Ulica:</p>
                    <p>Numer mieszkania:</p>
                    <p>Kod pocztowy:</p>
                    <p>Numer licencji:</p>
                </div>
                <div class="values">
                    <p><span><?php echo htmlspecialchars($user['name']); ?></span></p>
                    <p><span><?php echo htmlspecialchars($user['surname']); ?></span></p>
                    <p><span><?php echo htmlspecialchars($user['email']); ?></span></p>
                    <p><span><?php echo htmlspecialchars($user['phone_number']); ?></span></p>
                    <p><span><?php echo htmlspecialchars($user['country']); ?></span></p>
                    <p><span><?php echo htmlspecialchars($user['city']); ?></span></p>
                    <p><span><?php echo htmlspecialchars($user['street']); ?></span></p>
                    <p><span><?php echo htmlspecialchars($user['apartment']); ?></span></p>
                    <p><span><?php echo htmlspecialchars($user['postal_code']); ?></span></p>
                    <p><span><?php echo htmlspecialchars($user['license_number']); ?></span></p>
                </div>
            </div>
        </div>
        <h3>Twoje Rezerwacje</h3>
        <div class="rentals">
            <div class="rentals-container">
                <?php while ($rental = $rental_result->fetch_assoc()): ?>
                    <div class="rental">
                        <img src="<?php echo '../public/assets/images/' . htmlspecialchars($rental['vehicle_photo']); ?>"
                             alt="Car Image"
                             class="vehicle-photo" width="600" height="400">
                        <div class="rental-info">
                            <p><span>ID rezerwacji:</span> <?php echo htmlspecialchars($rental['id']); ?></p>
                            <p>
                                <span>Samochód:</span> <?php echo htmlspecialchars($rental['vehicle_name'] . ' ' . $rental['vehicle_model']); ?>
                            </p>
                            <p><span>Data rozpoczęcia:</span> <?php echo htmlspecialchars($rental['start_date']); ?></p>
                            <p><span>Data zakończenia:</span> <?php echo htmlspecialchars($rental['end_date']); ?></p>
                            <p><span>Pick-up:</span> <?php echo htmlspecialchars($rental['pick_up_location']); ?></p>
                            <p><span>Drop-off:</span> <?php echo htmlspecialchars($rental['drop_off_location']); ?></p>
                        </div>

                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <form action="../controllers/logout.php" method="POST">
            <button type="submit" class="logout-button primary-button">Wyloguj</button>
        </form>
    </div>
</div>
