<div class="main-slider">
    <!-- Slide 1 -->
    <div class="background" id="background"
         style="background-image: url('../public/assets/images/background-audi.jpg');">
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
    <div class="background" id="background"
         style="background-image: url('../public/assets/images/background-ferrari.jpg');">
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
    <div class="background" id="background"
         style="background-image: url('../public/assets/images/background-lamborghini.jpg');">
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
require_once('../controllers/functions.php');
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

$type = $_POST['type'] ?? 'Luxury';
$sql = "SELECT * FROM vehicles WHERE type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $type);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="vertical-line-container">
    <div class="vertical-line"></div>
</div>

<section class="section-cars">
    <div class="section-header">
        <p class="section-description">WYBIERZ SAMOCHÓD DLA SIEBIE</p>
        <h2 class="section-title">Flota Samochodów <span class="highlight">Luksusowych</span></h2>
    </div>
    <div class="slider-container">
        <button class="slide-button prev">
            <img src="../public/assets/icons/arrow_left.svg" alt="poprzedni">
        </button>
        <div class="car-slider">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $gearbox_types = [1 => 'Manualna', 2 => 'Automatyczna'];
                    $gearbox = $gearbox_types[$row['gearbox_type']] ?? 'Nieznany';
                    echo '
                <div class="car-card">
                    <img src="../public/assets/images/' . htmlspecialchars($row['image']) . '"
                         alt="' . htmlspecialchars($row['make']) . '" class="car-image"/>
                    <div class="car-info">
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
                        </div>
                    </div>
                </div>
                ';
                }
            } else {
                echo '<p style="color: azure">Nie udało nam się znaleźć samochodu dla podanych filtrów.</p>';
            }
            ?>
        </div>
        <button class="slide-button next">
            <img src="../public/assets/icons/arrow_right.svg" alt="następny">
        </button>
    </div>
</section>

<div class="vertical-line-container">
    <div class="vertical-line"></div>
</div>

<section class="section-rent-now">
    <h2 class="h-rent-now">WYPOŻYCZ TERAZ</h2>
    <h1 class="h-book-now">Zarezerwuj Swój Samochód</h1>
    <form action="../controllers/process_rental.php" method="POST" class="rental-bar" id="rental-form">
        <div class="rental-bar-item">
            <label for="car-type">Rodzaj samochodu</label>
            <div class="custom-select">
                <div class="select-wrapper">
                    <span class="selected-option">Wybierz rodzaj</span>
                    <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12"
                         xmlns="http://www.w3.org/2000/svg">
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
            <small class="error-message" id="car-type-error" style="color: red; display: none;">Proszę wybrać rodzaj
                samochodu!</small>
        </div>

        <div class="rental-bar-item">
            <label for="pick-up-location">Miejsce wynajmu</label>
            <div class="custom-select">
                <div class="select-wrapper">
                    <span class="selected-option">Wybierz miejsce</span>
                    <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12"
                         xmlns="http://www.w3.org/2000/svg">
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
            <small class="error-message" id="pick-up-location-error" style="color: red; display: none;">Proszę wybrać
                miejsce wynajmu!</small>
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
                    <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12"
                         xmlns="http://www.w3.org/2000/svg">
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
            <small class="error-message" id="drop-off-location-error" style="color: red; display: none;">Proszę wybrać
                miejsce zwrotu!</small>
        </div>

        <div class="rental-bar-item">
            <label for="rental-date-end">Data Zwrotu</label>
            <input type="date" id="rental-date-end" name="rental_date_end" lang="pl-PL" required>
        </div>

        <button class="primary-button" type="submit">Wypożycz Teraz</button>
    </form>
</section>

<div class="vertical-line-container">
    <div class="vertical-line"></div>
</div>

<section class="section-car-categories">
    <h3 class="categories-subtitle">KATEGORIE</h3>
    <h2 class="categories-title">Rodzaje <span class="highlight">Samochodów</span></h2>
    <div class="categories-container">
        <div class="category-card">
            <img src="../public/assets/images/categories/Luxury.jpg" alt="Luxury Cars">
            <h3>Luksusowe</h3>
            <div class="arrow-button-container">
                <button class="arrow-button" id="navigateButtonLuxury">
                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e8eaed"><path d="M206.67-160 160-206.67l486.67-486.66h-284V-760H760v397.33h-66.67v-284L206.67-160Z"/></svg>
                </button>
            </div>

        </div>
        <div class="category-card">
            <img src="../public/assets/images/categories/Sports.jpg" alt="Sports">
            <h3>Sportowe</h3>
            <div class="arrow-button-container">
                <button class="arrow-button" id="navigateButtonSports">
                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e8eaed"><path d="M206.67-160 160-206.67l486.67-486.66h-284V-760H760v397.33h-66.67v-284L206.67-160Z"/></svg>
                </button>
            </div>
        </div>
        <div class="category-card">
            <img src="../public/assets/images/categories/SUV.jpg" alt="SUV">
            <h3>SUV</h3>
            <div class="arrow-button-container">
                <button class="arrow-button" id="navigateButtonSUV">
                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e8eaed"><path d="M206.67-160 160-206.67l486.67-486.66h-284V-760H760v397.33h-66.67v-284L206.67-160Z"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>

<div class="vertical-line-container">
    <div class="vertical-line"></div>
</div>

<section class="section-rent-steps">
    <h3 class="steps-subtitle">KROKI</h3>
    <h2 class="steps-title">Proces <span class="highlight">Wypożyczenia</span></h2>
    <div class="steps-container">
        <div class="step-card">
            <h3>Wybierz Samochód</h3>
            <p>Zobacz naszą gamę samochodów, znajdź swój wymarzony model na następujące dni.</p>
            <div class="step-counter-container">
                <button class="step">
                    01.
                </button>
            </div>

        </div>
        <div class="step-card">
            <h3>Zarezerwuj</h3>
            <p>Nasza strona zapewni Ci płynne zarezerwowanie samochodu lub skontaktowanie się z nami.</p>
            <div class="step-counter-container">
                <button class="step">
                   02.
                </button>
            </div>
        </div>
        <div class="step-card">
            <h3>Czerp Radość Z Jazdy</h3>
            <p>Otrzymaj kluczyki i ciesz się z saamochodu. Traktujemy wszystkie nasze samochody z respektem.</p>
            <div class="step-counter-container">
                <button class="step">
                    03.
                </button>
            </div>
        </div>
    </div>
</section>

<div class="vertical-line-container">
    <div class="vertical-line"></div>
</div>

<script src="../public/main-slider.js" defer></script>
<script src="../public/car-slider.js" defer></script>
<script src="../public/rent-now.js" defer></script>
<script src="../public/rent-now-validate.js" defer></script>
<script src="../public/car-categories.js" defer></script>