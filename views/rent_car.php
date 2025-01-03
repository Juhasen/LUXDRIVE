<?php
require_once '../controllers/functions.php';
session_start();
require '../config/database.php';


$conn = connectToDatabase();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
    //fetch all data of user using prepare
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
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
closeConnection($conn);
?>


<div class="rent-car-container">
    <h1 class="rent-car-header">Rezerwacja</h1>
    <h2 class="spaced-header">POJAZDU</h2>
    <div class="car-container">
        <div class="car-card">
            <img src="../public/assets/images/<?php echo htmlspecialchars($car['image']); ?>"
                 alt="<?php echo htmlspecialchars($car['make']); ?>" class="car-image"/>
            <div class="car-info">
                <div class="car-specs">
                    <h2 class="car-name"><?php echo htmlspecialchars($car['make']) . ' ' . htmlspecialchars($car['model']); ?></h2>
                    <div class="car-details">
                        <span class="detail-icon">
                            <img src="../public/assets/icons/car-seat.png"
                                 alt="Seats"> <?php echo htmlspecialchars($car['seats']); ?>
                        </span>
                        <span class="detail-icon">
                            <img src="../public/assets/icons/gearbox.png"
                                 alt="Gearbox"> <?php echo htmlspecialchars($gearbox); ?>
                        </span>
                        <span class="detail-icon">
                            <img src="../public/assets/icons/luggage.png"
                                 alt="Luggage"> <?php echo htmlspecialchars($car['luggage']); ?>
                        </span>
                        <span class="detail-icon">
                            <img src="../public/assets/icons/calendar.png"
                                 alt="Year"> <?php echo htmlspecialchars($car['year']); ?>
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
                <button onclick="window.location.href='../public/index.php?page=login'" class="primary-button">Przejdź
                    do logowania
                </button>
            </div>
        <?php else: ?>


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
        <?php endif; ?>
    </div>
    <?php if ($isLoggedIn): ?>
        <section class="section-rent-now">
            <h2 class="h-rent-now">WYPOŻYCZ TERAZ</h2>
            <h1 class="h-book-now">Zarezerwuj Swój Samochód</h1>
            <form action="../controllers/cart.php" method="POST" class="rental-bar" id="rental-form">
                <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo htmlspecialchars($car_id); ?>">
                <div class="rental-bar-item">
                    <label for="pick-up-location">Miejsce Wynajmu</label>
                    <div class="custom-select">
                        <div class="select-wrapper">
                            <span class="selected-option">Wybierz miejsce</span>
                            <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 4.5L6 10L12 4.5H0Z" fill="white"/>
                            </svg>
                        </div>
                        <ul class="select-options">
                            <li class="select-option" data-value="Warszawa">Warszawa</li>
                            <li class="select-option" data-value="Kraków">Kraków</li>
                            <li class="select-option" data-value="Gdańsk">Gdańsk</li>
                        </ul>
                    </div>
                    <input type="hidden" id="pick-up-location" name="pick_up_location" required>
                    <small class="error-message" id="pick-up-location-error" style="color: red; display: none;">Proszę
                        wybrać
                        miejsce wynajmu!</small>
                </div>

                <div class="rental-bar-item">
                    <label for="rental-date-start">Data Wypożyczenia</label>
                    <input type="date" id="rental-date-start" name="rental_date_start" lang="pl-PL" required>
                </div>

                <div class="rental-bar-item">
                    <label for="drop-off-location">Miejsce Zwrotu</label>
                    <div class="custom-select">
                        <div class="select-wrapper">
                            <span class="selected-option">Wybierz miejsce</span>
                            <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 4.5L6 10L12 4.5H0Z" fill="white"/>
                            </svg>
                        </div>
                        <ul class="select-options">
                            <li class="select-option" data-value="Warszawa">Warszawa</li>
                            <li class="select-option" data-value="Kraków">Kraków</li>
                            <li class="select-option" data-value="Gdańsk">Gdańsk</li>
                        </ul>
                    </div>
                    <input type="hidden" id="drop-off-location" name="drop_off_location" required>
                    <small class="error-message" id="drop-off-location-error" style="color: red; display: none;">Proszę
                        wybrać
                        miejsce zwrotu!</small>
                </div>

                <div class="rental-bar-item">
                    <label for="rental-date-end">Data Zwrotu</label>
                    <input type="date" id="rental-date-end" name="rental_date_end" lang="pl-PL" required>
                </div>
            </form>
        </section>
        <div class="price-summary-box">
            <h3>PRZEJDŹ DALEJ</h3>
            <button class="primary-button submit-button" type="submit" id="submit-button">DODAJ DO KOSZYKA</button>
        </div>

    <?php endif; ?>

</div>

<script>
    // Assign the car price to a JavaScript variable
    const carPrice = <?php echo json_encode($car['price']); ?>;
    document.getElementById('total-price').textContent = carPrice + ' zł';

    // Function to calculate the rental price based on dates
    function calculateTotalPrice() {
        const startDate = document.getElementById('rental-date-start').value;
        const endDate = document.getElementById('rental-date-end').value;


        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);


            const timeDiff = end - start;
            let days = timeDiff / (1000 * 3600 * 24); // Convert milliseconds to days


            if (days < 1) {
                days = 1;
            }

            const totalPrice = carPrice * days;
            console.log(totalPrice);

            // Update the displayed total price
            document.getElementById('total-price').textContent = totalPrice.toFixed(0) + ' zł';
        }
    }

    // Attach event listeners to the date input fields
    document.getElementById('rental-date-start').addEventListener('change', calculateTotalPrice);
    document.getElementById('rental-date-end').addEventListener('change', calculateTotalPrice);
</script>

<script src="../public/rent-now.js" defer></script>
<script src="../public/rent-now-validate.js" defer></script>
<script src="../public/rent-now-input.js" defer></script>