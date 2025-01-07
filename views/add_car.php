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

    if (isset($_FILES['car_image'])) {
        $file_tmp = $_FILES['car_image']['tmp_name'];
        $file_name = $_FILES['car_image']['name'];
        $target_dir = '../public/assets/images/';
        $target_file = $target_dir . basename($file_name);
        $image_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid('car_', true) . '.' . $image_extension;

        // Przenieś plik do docelowego folderu
        if (move_uploaded_file($file_tmp, $target_dir . $new_file_name)) {
            // Zapisz nazwę pliku i inne dane w bazie danych
            $add_result = add_car($make, $model, $year, $price, $seats, $gearbox, $luggage, $type, $odometer, $vin, $location, $last_service, $license_plate, $new_file_name);

            if ($add_result) {
                header("Location: " . BASE_REDIRECT_URL . "admin&message=Samochód dodany pomyślnie.");
                exit;
            } else {
                $error_message = "Wystąpił błąd podczas dodawania samochodu.";
            }
        } else {
            $error_message = "Wystąpił błąd podczas przesyłania pliku.";
        }
    } else {
        $error_message = "Proszę wybrać plik do przesłania.";
    }
}
?>

<!-- Formularz dodawania samochodu -->
<section class="main-container">
    <div class="add-car-container">
        <div class="add-form">
            <h1>Dodaj Samochód</h1>
            <?php if (isset($error_message)) { ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php } ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="make">Marka:</label>
                    <input type="text" id="make" name="make" required>
                </div>
                <div class="form-group">
                    <label for="model">Model:</label>
                    <input type="text" id="model" name="model" required>
                </div>
                <div class="form-group">
                    <label for="year">Rok produkcji:</label>
                    <input type="number" id="year" name="year" required>
                </div>
                <div class="form-group">
                    <label for="price">Cena (za dzień):</label>
                    <input type="number" id="price" name="price" step="1" required>
                </div>
                <div class="form-group">
                    <label for="seats">Liczba miejsc:</label>
                    <input type="number" id="seats" name="seats" required>
                </div>
                <div class="form-group">
                    <label for="gearbox_type">Skrzynia biegów:</label>
                    <select id="gearbox_type" name="gearbox_type" required>
                        <option value="Manualna">Manualna</option>
                        <option value="Automatyczna">Automatyczna</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="luggage">Pojemność bagażnika:</label>
                    <input type="number" id="luggage" name="luggage" required>
                </div>
                <div class="form-group">
                    <label for="type">Typ samochodu:</label>
                    <select id="type" name="type" required>
                        <option value="Sports">Sports</option>
                        <option value="Luxury">Luxury</option>
                        <option value="SUV">SUV</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="odometer">Przebieg:</label>
                    <input type="number" id="odometer" name="odometer" required>
                </div>
                <div class="form-group">
                    <label for="vin">VIN:</label>
                    <input type="text" id="vin" name="vin" required>
                </div>
                <div class="form-group">
                    <label for="location">Lokalizacja:</label>
                    <input type="text" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="last_service">Ostatnia usługa:</label>
                    <input type="date" id="last_service" name="last_service" required>
                </div>
                <div class="form-group">
                    <label for="license_plate">Numer rejestracyjny:</label>
                    <input type="text" id="license_plate" name="license_plate" required>
                </div>
                <div class="form-group">
                    <label for="car_image">Zdjęcie samochodu:</label>
                    <input type="file" id="car_image" name="car_image" required>
                </div>
                <button type="submit" class="primary-button">Dodaj samochód</button>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select form elements
        const makeInput = document.getElementById('make');
        const modelInput = document.getElementById('model');
        const yearInput = document.getElementById('year');
        const priceInput = document.getElementById('price');
        const seatsInput = document.getElementById('seats');
        const gearboxInput = document.getElementById('gearbox_type');
        const luggageInput = document.getElementById('luggage');
        const licensePlateInput = document.getElementById('license_plate');
        const odometerInput = document.getElementById('odometer');
        const vinInput = document.getElementById('vin');
        const locationInput = document.getElementById('location');
        const lastServiceInput = document.getElementById('last_service');
        const imageInput = document.getElementById('image');

        // Select elements to display updates
        const carName = document.getElementById('car-name');
        const carSeats = document.getElementById('car-seats');
        const carGearbox = document.getElementById('car-gearbox');
        const carLuggage = document.getElementById('car-luggage');
        const carYear = document.getElementById('car-year');
        const carPrice = document.getElementById('car-price');

        // Update the car details in real-time as the user types
        makeInput.addEventListener('input', function () {
            carName.textContent = `${makeInput.value} ${modelInput.value}`;
        });

        modelInput.addEventListener('input', function () {
            carName.textContent = `${makeInput.value} ${modelInput.value}`;
        });

        yearInput.addEventListener('input', function () {
            carYear.textContent = yearInput.value;
        });

        priceInput.addEventListener('input', function () {
            carPrice.textContent = priceInput.value;
        });

        seatsInput.addEventListener('input', function () {
            carSeats.textContent = seatsInput.value;
        });

        gearboxInput.addEventListener('change', function () {
            carGearbox.textContent = gearboxInput.value;
        });

        luggageInput.addEventListener('input', function () {
            carLuggage.textContent = luggageInput.value;
        });
    });
</script>
