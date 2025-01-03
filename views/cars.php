<?php
require '../controllers/filter_cars.php';

$result = getFilteredCars($_GET);

?>

<section class="main-container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Filtry</h2>
        <form id="filter-form" method="GET" action="../public/index.php">
            <input type="hidden" name="page" value="cars">
            <div class="filter-group">
                <label for="gearbox">Typ skrzyni biegów</label>
                <select name="gearbox" id="gearbox">
                    <option value="">Każda</option>
                    <option value="2" <?php echo (isset($_GET['gearbox']) && $_GET['gearbox'] == '2') ? 'selected' : ''; ?>>
                        Automatyczna
                    </option>
                    <option value="1" <?php echo (isset($_GET['gearbox']) && $_GET['gearbox'] == '1') ? 'selected' : ''; ?>>
                        Manualna
                    </option>
                </select>
            </div>

            <div class="filter-group">
                <label for="car_type">Rodzaj samochodu:</label>
                <select name="car_type" id="car_type">
                    <option value="">Wszystkie</option>
                    <option value="Sports" <?php echo (isset($_GET['car_type']) && $_GET['car_type'] == 'Sports') ? 'selected' : ''; ?>>
                        Sportowe
                    </option>
                    <option value="Luxury" <?php echo (isset($_GET['car_type']) && $_GET['car_type'] == 'Luxury') ? 'selected' : ''; ?>>
                        Luksusowe
                    </option>
                    <option value="SUV" <?php echo (isset($_GET['car_type']) && $_GET['car_type'] == 'SUV') ? 'selected' : ''; ?>>
                        SUV
                    </option>
                </select>
            </div>

            <div class="filter-group">
                <label>Min. ilość siedzeń</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="seats"
                               value="" <?php echo !isset($_GET['seats']) || $_GET['seats'] === '' ? 'checked' : ''; ?>>
                        <span>Dowolna</span>
                    </label>
                    <label>
                        <input type="radio" name="seats"
                               value="2" <?php echo isset($_GET['seats']) && htmlspecialchars($_GET['seats']) == '2' ? 'checked' : ''; ?>>
                        <span>2</span>
                    </label>
                    <label>
                        <input type="radio" name="seats"
                               value="4" <?php echo isset($_GET['seats']) && htmlspecialchars($_GET['seats']) == '4' ? 'checked' : ''; ?>>
                        <span>4</span>
                    </label>
                    <label>
                        <input type="radio" name="seats"
                               value="5" <?php echo isset($_GET['seats']) && htmlspecialchars($_GET['seats']) == '5' ? 'checked' : ''; ?>>
                        <span>5</span>
                    </label>
                    <label>
                        <input type="radio" name="seats"
                               value="7" <?php echo isset($_GET['seats']) && htmlspecialchars($_GET['seats']) == '7' ? 'checked' : ''; ?>>
                        <span>7</span>
                    </label>
                </div>
            </div>


            <div class="filter-group">
                <label for="price">Max Cena (zł)</label>
                <input type="number" name="price" id="price" placeholder="Np. 5000"
                       value="<?php echo isset($_GET['price']) ? htmlspecialchars($_GET['price']) : ''; ?>">
            </div>
            <div class="filter-group">
                <button type="submit" class="primary-button">Zastosuj filtry</button>
            </div>
        </form>
    </div>

    <!-- CARS -->
    <div class="cars-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="car-card">
                    <img src="../public/assets/images/<?php echo htmlspecialchars($row['image']); ?>"
                         alt="<?php echo htmlspecialchars($row['make']); ?>" class="car-image"/>
                    <div class="car-info">
                        <div class="car-specs">
                            <h2 class="car-name"><?php echo htmlspecialchars($row['make']) . ' ' . htmlspecialchars($row['model']); ?></h2>
                            <div class="car-details">
                        <span class="detail-icon">
                            <img src="../public/assets/icons/car-seat.png" alt="Seats"> <?php echo htmlspecialchars($row['seats']); ?>
                        </span>
                                <span class="detail-icon">
                            <img src="../public/assets/icons/gearbox.png" alt="Gearbox"> <?php echo htmlspecialchars($row['gearbox_type']); ?>
                        </span>
                                <span class="detail-icon">
                            <img src="../public/assets/icons/luggage.png" alt="Luggage"> <?php echo htmlspecialchars($row['luggage']); ?>
                        </span>
                                <span class="detail-icon">
                            <img src="../public/assets/icons/calendar.png" alt="Year"> <?php echo htmlspecialchars($row['year']); ?>
                        </span>
                            </div>
                        </div>
                        <div class="car-price">
                            <button class="primary-button reserve-button"
                                    onclick="window.location.href='../public/index.php?page=rent_car&car_id=<?php echo urlencode($row['id']); ?>';">
                                Rezerwuj <img src="../public/assets/icons/car-key.png" alt="car key">
                            </button>
                            <span class="price"><?php echo number_format($row['price'], 0); ?>zł <small>/Doba</small></span>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p style="color: azure">Nie udało nam się znaleźć samochodu dla podanych filtrów.</p>';
        }
        ?>
    </div>
</section>
