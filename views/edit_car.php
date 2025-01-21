<?php
require '../controllers/functions.php';
require_once '../controllers/constants.php';
session_start();

// Check if user is logged in and is an admin
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

// Check if car_id is provided
if (empty($_GET['car_id'])) {
    echo "Invalid car ID.";
    exit;
}

$car_id = intval($_GET['car_id']);
$car = get_car_info_by_id($car_id);

if (!$car) {
    echo "Car not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = htmlspecialchars(trim($_POST['make']));
    $model = htmlspecialchars(trim($_POST['model']));
    $year = intval($_POST['year']);
    $price = intval($_POST['price']);
    $seats = intval($_POST['seats']);
    $gearbox = htmlspecialchars(trim($_POST['gearbox_type']));
    $luggage = intval($_POST['luggage']);
    $type = htmlspecialchars(trim($_POST['type']));
    $odometer = intval($_POST['odometer']);
    $vin = htmlspecialchars(trim($_POST['vin']));
    $location = htmlspecialchars(trim($_POST['location']));
    $last_service = htmlspecialchars(trim($_POST['last_service']));
    $license_plate = htmlspecialchars(trim($_POST['license_plate']));

    if (!isset($_FILES['car_image']) || $_FILES['car_image']['error'] == UPLOAD_ERR_NO_FILE) {
        // No file uploaded, skip the file handling block
        $update_result = update_car($car_id, $make, $model, $year, $price, $seats, $gearbox, $luggage, $type, $odometer, $vin, $location, $last_service, $license_plate, null);
    } else {
        // Process file upload
        $file_tmp = $_FILES['car_image']['tmp_name'];
        $file_name = $_FILES['car_image']['name'];
        $target_dir = '../public/assets/images/';
        $target_file = $target_dir . basename($file_name);
        $image_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid('car_', true) . '.' . $image_extension;
        sleep(3);
        if (move_uploaded_file($file_tmp, $target_dir . $new_file_name)) {
            $old_image = $car['image'];
            $update_result = update_car($car_id, $make, $model, $year, $price, $seats, $gearbox, $luggage, $type, $odometer, $vin, $location, $last_service, $license_plate, $new_file_name);
            if ($update_result && file_exists($target_dir . $old_image)) {
                unlink($target_dir . $old_image);
            }
        } else {
            $error_message = "Wystąpił błąd podczas przesyłania pliku.";
        }
    }

    if ($update_result) {
        header("Location: " . BASE_REDIRECT_URL . "admin&message=Samochód zaktualizowany pomyślnie.");
        exit;
    } else {
        $error_message = "Nie udało się zaktualizować samochodu. Spróbuj ponownie.";
    }
}
?>

<section class="main-container">

    <div class="edit-car-container">
        <!-- Car Edit Form -->
        <div class="edit-form">
            <h1>Edytuj Samochód</h1>
            <?php if (isset($error_message)) { ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php } ?>
            <form method="POST" action="" id="edit-car-form" enctype="multipart/form-data">
                <div class="form-column">
                    <div class="form-group">
                        <label for="make">Marka:</label>
                        <input type="text" id="make" name="make" value="<?php echo htmlspecialchars(trim($car['make'])); ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="model">Model:</label>
                        <input type="text" id="model" name="model"
                               value="<?php echo htmlspecialchars(trim($car['model'])); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="year">Rok produkcji:</label>
                        <input type="number" id="year" name="year" value="<?php echo htmlspecialchars(trim($car['year'])); ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="price">Cena (za dzień):</label>
                        <input type="number" id="price" name="price" step="1"
                               value="<?php echo htmlspecialchars(trim($car['price'])); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="seats">Liczba miejsc:</label>
                        <input type="number" id="seats" name="seats"
                               value="<?php echo htmlspecialchars(trim($car['seats'])); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gearbox_type">Skrzynia biegów:</label>
                        <select id="gearbox_type" name="gearbox_type" required>
                            <option value="Manualna" <?php echo $car['gearbox_type'] === 'Manualna' ? 'selected' : ''; ?>>
                                Manualna
                            </option>
                            <option value="Automatyczna" <?php echo $car['gearbox_type'] === 'Automatyczna' ? 'selected' : ''; ?>>
                                Automatyczna
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="luggage">Pojemność bagażnika:</label>
                        <input type="number" id="luggage" name="luggage"
                               value="<?php echo htmlspecialchars(trim($car['luggage'])); ?>" required>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="type">Typ samochodu:</label>
                        <select id="type" name="type" required>
                            <option value="Sports" <?php echo $car['type'] === 'Sports' ? 'selected' : ''; ?>>Sports
                            </option>
                            <option value="Luxury" <?php echo $car['type'] === 'Luxury' ? 'selected' : ''; ?>>Luxury
                            </option>
                            <option value="SUV" <?php echo $car['type'] === 'SUV' ? 'selected' : ''; ?>>SUV</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="odometer">Przebieg:</label>
                        <input type="number" id="odometer" name="odometer"
                               value="<?php echo htmlspecialchars(trim($car['odometer'])); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vin">VIN:</label>
                        <input type="text" id="vin" name="vin" value="<?php echo htmlspecialchars(trim($car['vin'])); ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="location">Lokalizacja:</label>
                        <select id="location" name="location" required>
                            <option value="Kraków" <?php echo $car['location'] === 'Kraków' ? 'selected' : ''; ?>>
                                Kraków
                            </option>
                            <option value="Warszawa" <?php echo $car['location'] === 'Warszawa' ? 'selected' : ''; ?>>
                                Warszawa
                            </option>
                            <option value="Gdańsk" <?php echo $car['location'] === 'Gdańsk' ? 'selected' : ''; ?>>
                                Gdańsk
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="last_service">Ostatni serwis:</label>
                        <input type="date" id="last_service" name="last_service"
                               value="<?php echo htmlspecialchars(trim($car['last_service'])); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="license_plate">Numer rejestracyjny:</label>
                        <input type="text" id="license_plate" name="license_plate"
                               value="<?php echo htmlspecialchars(trim($car['license_plate'])); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="car_image">Zdjęcie samochodu(jeśli chcesz zamienić):</label>
                        <input type="file" id="car_image" name="car_image">
                    </div>
                </div>
                <button type="submit" class="primary-button">Zaktualizuj samochód</button>
            </form>
        </div>

        <!-- Original Car Info -->
        <div class="car-info-container">
            <h2 class="car-info-header">Obecne dane samochodu</h2>
            <div class="car-image-container">
                <img src="../public/assets/images/<?php echo htmlspecialchars(trim($car['image'])); ?>" alt="Car Image">
            </div>
            <ul class="car-info-list">
                <li><strong>Marka:</strong> <?php echo htmlspecialchars(trim($car['make'])); ?></li>
                <li><strong>Model:</strong> <?php echo htmlspecialchars(trim($car['model'])); ?></li>
                <li><strong>Rok produkcji:</strong> <?php echo htmlspecialchars(trim($car['year'])); ?></li>
                <li><strong>Cena:</strong> <?php echo htmlspecialchars(trim($car['price'])); ?> zł dziennie</li>
                <li><strong>Liczba miejsc:</strong> <?php echo htmlspecialchars(trim($car['seats'])); ?></li>
                <li><strong>Skrzynia biegów:</strong> <?php echo htmlspecialchars(trim($car['gearbox_type'])); ?></li>
                <li><strong>Pojemność bagażnika:</strong> <?php echo htmlspecialchars(trim($car['luggage'])); ?> l</li>
                <li><strong>Typ:</strong> <?php echo htmlspecialchars(trim($car['type'])); ?></li>
                <li><strong>Przebieg:</strong> <?php echo htmlspecialchars(trim($car['odometer'])); ?> km</li>
                <li><strong>VIN:</strong> <?php echo htmlspecialchars(trim($car['vin'])); ?></li>
                <li><strong>Lokalizacja:</strong> <?php echo htmlspecialchars(trim($car['location'])); ?></li>
                <li><strong>Ostatni serwis:</strong> <?php echo htmlspecialchars(trim($car['last_service'])); ?></li>
                <li><strong>Numer rejestracyjny:</strong> <?php echo htmlspecialchars(trim($car['license_plate'])); ?></li>
            </ul>
        </div>
    </div>
</section>
