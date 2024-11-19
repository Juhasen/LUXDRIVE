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
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $gearbox = $row['gearbox_type'] == 1 ? 'Automatyczna' : 'Manual';

                echo '
                <div class="car-card">
                    <img src="../public/assets/images/' . htmlspecialchars($row['image']) . '"
                         alt="' . htmlspecialchars($row['name']) . '" class="car-image"/>
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
                            <button class="primary-button">Detale</button>
                            <span class="price">' . number_format($row['price'], 2) . 'zł <small>/Doba</small></span>
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
    <button class="slide-button next">
        <img src="../public/assets/icons/arrow_right.svg" alt="następny">
    </button>
</section>

<section class="section-rent-now">
    ALe to jest jakiś tekst
</section>

<?php
$conn->close();
?>