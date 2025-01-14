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
$result = get_user_details_by_id($user_id);
$user = $result->fetch_assoc();

//if is Admin
$isAdmin = $user['isAdmin'];

// Get rentals with vehicle details
$stmt = $conn->prepare("SELECT Rentals.*, Vehicles.make AS vehicle_name, Vehicles.model AS vehicle_model , Vehicles.image AS vehicle_photo 
                        FROM Rentals 
                        JOIN Vehicles ON Rentals.vehicle_id = Vehicles.id 
                        WHERE Rentals.user_id = ?
                        ORDER BY Rentals.id DESC");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$rental_result = $stmt->get_result();
$stmt->close();
closeConnection($conn);
?>

<div class="main-container">
    <div class="profile-container">
        <?php if ($isAdmin == 'yes') {
            header("Location: " . BASE_REDIRECT_URL . "admin");
        }
        ?>
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
                    <p><span><?php echo htmlspecialchars(trim($user['name'])); ?></span></p>
                    <p><span><?php echo htmlspecialchars(trim($user['surname'])); ?></span></p>
                    <p><span><?php echo htmlspecialchars(trim($user['email'])); ?></span></p>
                    <p><span><?php echo htmlspecialchars(trim($user['phone_number'])); ?></span></p>
                    <p><span><?php echo htmlspecialchars(trim($user['country'])); ?></span></p>
                    <p><span><?php echo htmlspecialchars(trim($user['city'])); ?></span></p>
                    <p><span><?php echo htmlspecialchars(trim($user['street'])); ?></span></p>
                    <p><span><?php echo htmlspecialchars(trim($user['apartment'])); ?></span></p>
                    <p><span><?php echo htmlspecialchars(trim($user['postal_code'])); ?></span></p>
                    <p><span><?php echo htmlspecialchars(trim($user['license_number'])); ?></span></p>

                </div>
            </div>
        </div>
        <h3>Twoje Rezerwacje</h3>
        <div class="rentals">
            <div class="rentals-container">
                <?php while ($rental = $rental_result->fetch_assoc()):
                    $isExpired = strtotime($rental['end_date']) < time(); // Sprawdzenie, czy rezerwacja wygasła
                    ?>
                    <div class="rental <?php echo $isExpired ? 'expired' : ''; ?>">
                        <img src="<?php echo '../public/assets/images/' . htmlspecialchars(trim($rental['vehicle_photo'])); ?>"
                             alt="Car Image"
                             class="vehicle-photo" width="600" height="400">
                        <div class="rental-info">
                            <p><span>ID rezerwacji:</span> <?php echo htmlspecialchars(trim($rental['id'])); ?></p>
                            <p>
                                <span>Samochód:</span> <?php echo htmlspecialchars(trim($rental['vehicle_name'] . ' ' . $rental['vehicle_model'])); ?>
                            </p>
                            <p>
                                <span>Data rozpoczęcia:</span> <?php echo htmlspecialchars(trim($rental['start_date'])); ?>
                            </p>
                            <p><span>Data zakończenia:</span> <?php echo htmlspecialchars(trim($rental['end_date'])); ?>
                            </p>
                            <p><span>Odbiór:</span> <?php echo htmlspecialchars(trim($rental['pick_up_location'])); ?>
                            </p>
                            <p><span>Zwrot:</span> <?php echo htmlspecialchars(trim($rental['drop_off_location'])); ?>
                            </p>

                            <?php if ($isExpired): ?>
                                <p class="expired-text">Rezerwacja wygasła</p>
                            <?php endif; ?>
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
