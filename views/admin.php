<?php
require '../controllers/functions.php';
require_once '../controllers/constants.php';
session_start();

$is_logged_in = isset($_SESSION['user_id']);
if (!$is_logged_in) {
    header("Location: " . BASE_REDIRECT_URL . "home");
    exit;
}

$isAdmin = check_if_user_is_admin($_SESSION['user_id']);
if ($isAdmin != 'yes') {
    header("Location: " . BASE_REDIRECT_URL . "home");
    exit;
}

require '../controllers/filter_cars.php';

$result = get_filtered_cars($_GET);


if (isset($_GET['message']) && !empty($_GET['message'])) {
    echo '<p class="success-message">' . htmlspecialchars($_GET['message']) . '</p>';
}


?>

<h1 class="admin-heading">Panel Administratora</h1>
<div class="admin-buttons-container">
    <button class="secondary-button" onclick="window.location.href='../public/index.php?page=add_car';">DODAJ NOWY SAMOCHÓD</button>
    <button class="secondary-button" onclick="window.location.href='../public/index.php?page=users';">ZARZĄDZAJ UŻYTKOWNIKAMI</button>
</div>

<form action="../controllers/logout.php" method="POST">
    <button type="submit" class="logout-button primary-button">Wyloguj</button>
</form>


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
                <input type="number" name="price" id="price" placeholder="Np. 5000" min="0"
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
                    <button class="delete-button delete-button-placement"
                            onclick="confirmDelete('<?php echo $row['id']; ?>', '<?php echo trim(htmlspecialchars($row['make'] . ' ' . $row['model'])); ?>')">
                        x
                    </button>
                    <img src="../public/assets/images/<?php echo htmlspecialchars($row['image']); ?>"
                         alt="<?php echo htmlspecialchars($row['make']); ?>" class="car-image"/>
                    <div class="car-info">
                        <div class="car-specs">
                            <h2 class="car-name"><?php echo htmlspecialchars($row['make']) . ' ' . htmlspecialchars($row['model']); ?></h2>
                            <div class="car-details">
                        <span class="detail-icon">
                            <img src="../public/assets/icons/car-seat.png"
                                 alt="Seats"> <?php echo htmlspecialchars($row['seats']); ?>
                        </span>
                                <span class="detail-icon">
                            <img src="../public/assets/icons/gearbox.png"
                                 alt="Gearbox"> <?php echo htmlspecialchars($row['gearbox_type']); ?>
                        </span>
                                <span class="detail-icon">
                            <img src="../public/assets/icons/luggage.png"
                                 alt="Luggage"> <?php echo htmlspecialchars($row['luggage']); ?>
                        </span>
                                <span class="detail-icon">
                            <img src="../public/assets/icons/calendar.png"
                                 alt="Year"> <?php echo htmlspecialchars($row['year']); ?>
                        </span>
                            </div>
                        </div>
                        <div class="car-price">
                            <button class="primary-button reserve-button edit-button"
                                    onclick="window.location.href='../public/index.php?page=edit_car&car_id=<?php echo urlencode($row['id']); ?>';">
                                EDYTUJ <img src="../public/assets/icons/edit.png" alt="car key">
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


<script>
    function confirmDelete(carId, carName) {
        if (confirm(`Czy na pewno chcesz usunąć samochód: ${carName}?`)) {
            window.location.href = `../controllers/delete_car.php?car_id=${carId}`;
        }
    }
</script>
