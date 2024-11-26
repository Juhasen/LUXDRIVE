<div class="main-slider">
    <!-- Slide 1 -->
    <div class="background" style="background-image: url('../public/assets/images/background-audi.jpg');">
        <div class="container">
            <p class="premium">. PREMIUM</p>
            <h1>Audi R8</h1>
            <p class="car-details">
                <span class="car-name">Egzotyczny</span>
                <span class="price">
                    <span class="price-amount">3000zł</span>
                    <span class="price-unit">/Doba</span>
                </span>
            </p>
            <div class="main-button-container">
                <button class="view-detail-button">
                    Pokaż Szczegóły
                    <i class="fas fa-arrow-up-right-from-square" style="margin-left: 8px;"></i>
                </button>
                <button class="rent-now-button">
                    Wypożycz Teraz
                    <i class="fas fa-arrow-up-right-from-square" style="margin-left: 8px;"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Slide 2 -->
    <div class="background" style="background-image: url('../public/assets/images/background-ferrari.jpg');">
        <div class="container">
            <p class="premium">. PREMIUM</p>
            <h1>Ferrari LaFerrari</h1>
            <p class="car-details">
                <span class="car-name">Luksusowy</span>
                <span class="price">
                    <span class="price-amount">5000zł</span>
                    <span class="price-unit">/Doba</span>
                </span>
            </p>
            <div class="main-button-container">
                <button class="view-detail-button">
                    Pokaż Szczegóły
                    <i class="fas fa-arrow-up-right-from-square" style="margin-left: 8px;"></i>
                </button>
                <button class="rent-now-button">
                    Wypożycz Teraz
                    <i class="fas fa-arrow-up-right-from-square" style="margin-left: 8px;"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Slide 3 -->
    <div class="background" style="background-image: url('../public/assets/images/background-lamborghini.jpg');">
        <div class="container">
            <p class="premium">. PREMIUM</p>
            <h1>Lamborghini Huracan</h1>
            <p class="car-details">
                <span class="car-name">Egzotyczny</span>
                <span class="price">
                    <span class="price-amount">7000zł</span>
                    <span class="price-unit">/Doba</span>
                </span>
            </p>
            <div class="main-button-container">
                <button class="view-detail-button">
                    Pokaż Szczegóły
                    <i class="fas fa-arrow-up-right-from-square" style="margin-left: 8px;"></i>
                </button>
                <button class="rent-now-button">
                    Wypożycz Teraz
                    <i class="fas fa-arrow-up-right-from-square" style="margin-left: 8px;"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<?php
require_once('/opt/lampp/htdocs/IAB/controllers/functions.php');
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

$sql = "SELECT * FROM Vehicles WHERE type = 'luxury'";
$result = $conn->query($sql);
?>

<section class="section-cars">
    <div class="section-header">
        <p class="section-description">WYBIERZ SAMOCHÓD DLA SIEBIE</p>
        <h2 class="section-title">Flota Samochodów <span class="highlight">Luksusowych</span></h2>
    </div>
    <button class="slide-button prev">
        <img src="../public/assets/icons/arrow_left.svg" alt="poprzedni">
    </button>
    <div class="car-slider">
        <?php
        generateCarCards($result);
        ?>
    </div>
    <button class="slide-button next">
        <img src="../public/assets/icons/arrow_right.svg" alt="następny">
    </button>
</section>

<section class="section-rent-now">
    <h2 class="h-rent-now">WYPOŻYCZ TERAZ</h2>
    <h1 class="h-book-now">Zarezerwuj Swój Samochód</h1>
    <form action="../controllers/process_rental.php" method="POST" class="rental-bar">
        <div class="rental-bar-item">
            <label for="car-type">Rodzaj samochodu</label>
            <div class="custom-select">
                <div class="select-wrapper">
                    <span class="selected-option">Wybierz rodzaj</span>
                    <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 4.5L6 10L12 4.5H0Z" fill="white"/>
                    </svg>
                </div>
                <ul class="select-options">
                    <li class="select-option" data-value="sport">Sportowy</li>
                    <li class="select-option" data-value="suv">SUV</li>
                    <li class="select-option" data-value="luxury">Luksusowy</li>
                </ul>
            </div>
            <input type="hidden" id="car-type" name="car_type" required>
        </div>

        <div class="rental-bar-item">
            <label for="pick-up-location">Miejsce wynajmu</label>
            <div class="custom-select">
                <div class="select-wrapper">
                    <span class="selected-option">Wybierz miejsce</span>
                    <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 4.5L6 10L12 4.5H0Z" fill="white"/>
                    </svg>
                </div>
                <ul class="select-options">
                    <li class="select-option" data-value="warsaw">Warszawa</li>
                    <li class="select-option" data-value="krakow">Kraków</li>
                    <li class="select-option" data-value="gdansk">Gdańsk</li>
                </ul>
            </div>
            <input type="hidden" id="pick-up-location" name="pick_up_location" required>
        </div>

        <div class="rental-bar-item">
            <label for="rental-date-start">Data Wypożyczenia</label>
            <input type="date" id="rental-date-start" name="rental_date_start" lang="pl-PL" required>
        </div>

        <div class="rental-bar-item">
            <label for="drop-off-location">Miejsce zwrotu</label>
            <div class="custom-select">
                <div class="select-wrapper">
                    <span class="selected-option">Wybierz miejsce</span>
                    <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 4.5L6 10L12 4.5H0Z" fill="white"/>
                    </svg>
                </div>
                <ul class="select-options">
                    <li class="select-option" data-value="warsaw">Warszawa</li>
                    <li class="select-option" data-value="krakow">Kraków</li>
                    <li class="select-option" data-value="gdansk">Gdańsk</li>
                </ul>
            </div>
            <input type="hidden" id="drop-off-location" name="drop_off_location" required>
        </div>

        <div class="rental-bar-item">
            <label for="rental-date-end">Data Zwrotu</label>
            <input type="date" id="rental-date-end" name="rental_date_end" lang="pl-PL" required>
        </div>

        <button class="primary-button" type="submit">Wypożycz Teraz</button>
    </form>
</section>

<section style="height: 50vh">

</section>

