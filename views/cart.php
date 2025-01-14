<?php
require_once '../controllers/functions.php';
session_start();
$is_logged_in = isset($_SESSION['user_id']);

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add, remove, and display actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $index = intval($_POST['index']);

        // Usuwanie elementu z koszyka
        if ($_POST['action'] === 'remove' && isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        // Aktualizacja dodatkowych opcji
        if ($_POST['action'] === 'update' && isset($_SESSION['cart'][$index])) {
            $_SESSION['cart'][$index]['options'] = $_POST['options'][$index] ?? [];
        }
    }
}

$cart = $_SESSION['cart'];

$services = get_additional_services();
?>

<div class="main-container">
    <div class="cart">
        <?php
        if (!$is_logged_in): ?>
            <h1>Proszę się zalogować, aby zobaczyć koszyk</h1>
        <?php else: ?>
            <div class="cart-container">
                <h1>Twój Koszyk</h1>
                <?php if (empty($cart)): ?>
                    <p>Twój koszyk jest pusty.</p>
                <?php else: ?>
                    <?php foreach ($cart as $index => $item): ?>
                        <div class="cart-elem">
                            <div class="cart-image-name-container">
                                <strong>Samochód:</strong>
                                <?php displayVehicleName($item['vehicleId']); ?>
                                <?php displayCarImage($item['vehicleId']); ?>
                            </div>
                            <div class="cart-details-container">
                                <ul>
                                    <li>
                                        <strong>Odbiór:</strong> <?php echo htmlspecialchars(trim($item['pickUpLocation'])); ?>
                                    </li>
                                    <li>
                                        <strong>Zwrot:</strong> <?php echo htmlspecialchars(trim($item['dropOffLocation'])); ?>
                                    </li>
                                    <li>
                                        <strong>Od:</strong> <?php echo htmlspecialchars(date('d-m-Y', strtotime(trim($item['rentalDateStart'])))); ?>
                                    </li>
                                    <li>
                                        <strong>Do:</strong> <?php echo htmlspecialchars(date('d-m-Y', strtotime(trim($item['rentalDateEnd'])))); ?>
                                    </li>

                                </ul>
                            </div>
                            <div class="cart-options">
                                <strong>Dodatkowe opcje:</strong>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">

                                    <?php foreach ($services as $service): ?>
                                        <label>
                                            <input type="checkbox" name="options[<?php echo $index; ?>][]"
                                                   value="<?php echo htmlspecialchars($service['id']); ?>"
                                                <?php echo isset($item['options']) && in_array($service['id'], $item['options']) ? 'checked' : ''; ?>>
                                            <?php echo htmlspecialchars(trim($service['name'])); ?>
                                            - <?php echo number_format($service['price'], 0, '.', ''); ?> PLN
                                        </label><br>
                                    <?php endforeach; ?>

                                    <button type="submit" class="secondary-button">Zaktualizuj opcje</button>
                                </form>
                            </div>
                            <?php
                            $item['price'] = get_cars_price($item['vehicleId']);
                            // Obliczanie liczby dni wynajmu
                            $rentDays = (strtotime($item['rentalDateEnd']) - strtotime($item['rentalDateStart'])) / (60 * 60 * 24);

                            // Cena wynajmu samochodu
                            $carRentalPrice = $item['price'] * $rentDays;

                            // Cena za dodatkowe usługi
                            $additionalPrice = 0;
                            if (isset($item['options'])) {
                                foreach ($item['options'] as $selectedOption) {
                                    foreach ($services as $service) {
                                        if ($service['id'] == $selectedOption) {
                                            $additionalPrice += $service['price'];
                                            break;
                                        }
                                    }
                                }
                            }
                            // Całkowita cena
                            $totalPrice = $carRentalPrice + $additionalPrice;
                            ?>

                            <div class="cart-price">
                                <strong>Cena:</strong>
                                <div class="price">
                                    <?php echo number_format($totalPrice, 2, '.', ''); ?> PLN
                                </div>
                            </div>
                            <form method="POST" onsubmit="return confirmDelete()">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit" class="delete-button delete-item-button">Usuń</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php
$totalPrice = 0;
foreach ($cart as $index => $item) {
    // Same calculations for each item
    $item['price'] = get_cars_price($item['vehicleId']);
    $rentDays = (strtotime($item['rentalDateEnd']) - strtotime($item['rentalDateStart'])) / (60 * 60 * 24);
    $carRentalPrice = $item['price'] * $rentDays;

    $additionalPrice = 0;
    if (isset($item['options'])) {
        foreach ($item['options'] as $selectedOption) {
            foreach ($services as $service) {
                if ($service['id'] == $selectedOption) {
                    $additionalPrice += $service['price'];
                    break;
                }
            }
        }
    }
    $totalPrice += $carRentalPrice + $additionalPrice;
}
$_SESSION['totalCost'] = $totalPrice;
?>

<div class="sticky-footer">
    <div class="footer-content">
        <strong>Całkowita cena: </strong>
        <div class="total-price">
            <?php echo number_format($totalPrice, 2, '.', ''); ?> PLN
        </div>
        <button class="primary-button">Przejdź do płatności</button>
    </div>
</div>

<div id="payment-popup" class="payment-popup hide">
    <div class="payment-popup-content">
        <h2>Wybierz metodę płatności</h2>
        <button class="payment-button" onclick="selectPaymentMethod('Karta płatnicza')">
            <img src="../public/assets/icons/visa.svg" alt="karta płatnicza">
            Karta płatnicza
        </button>
        <button class="payment-button" onclick="selectPaymentMethod('Google Pay')">
            <img src="../public/assets/icons/googlepay.svg" alt="google pay">Google Pay
        </button>
        <button class="payment-button" onclick="selectPaymentMethod('BLIK')">
            <img src="../public/assets/icons/BLIK.webp" alt="BLIK">
            BLIK
        </button>
        <button class="payment-button" onclick="selectPaymentMethod('Przelew')">
            <img src="../public/assets/icons/przelew.svg" alt="przelew">
            Przelew
        </button>
        <br><br>
        <button type="button" class="delete-button" onclick="closePaymentPopup()">Anuluj</button>
    </div>
</div>

<!-- BLIK Transaction Popup -->
<div id="blik-popup" class="payment-popup hide">
    <div class="payment-popup-content">
        <h2>Wprowadź kod BLIK</h2>
        <form id="blik-form" action="../controllers/process_rental.php" method="POST">
            <label for="blik-code">Kod BLIK:</label>
            <input type="text" id="blik-code" name="blik-code" maxlength="6" pattern="\d{6}" required
                   placeholder="Wprowadź 6-cyfrowy kod">
            <button type="submit" class="secondary-button">Potwierdź BLIK</button>
            <button type="button" class="delete-button" onclick="closeBlikPopup()">Anuluj</button>
        </form>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm("Czy na pewno chcesz usunąć ten element z koszyka?");
    }

    // Function to show the payment popup
    function showPaymentPopup() {
        const popup = document.getElementById('payment-popup');
        popup.classList.remove('hide');
        popup.classList.add('show');
    }

    // Function to close the payment popup
    function closePaymentPopup() {
        const popup = document.getElementById('payment-popup');
        popup.classList.remove('show');
        popup.classList.add('hide');
    }

    // Function to show the BLIK popup
    function showBlikPopup() {
        const popup = document.getElementById('blik-popup');
        popup.classList.remove('hide');
        popup.classList.add('show');
    }

    // Function to close the BLIK popup
    function closeBlikPopup() {
        const popup = document.getElementById('blik-popup');
        popup.classList.remove('show');
        popup.classList.add('hide');
    }

    // Function to handle the selection of a payment method
    function selectPaymentMethod(paymentMethod) {
        if (paymentMethod === 'BLIK') {
            showBlikPopup(); // Show the BLIK popup for BLIK payment method
        } else {
            closePaymentPopup(); // Close the payment method selection popup for other methods
        }
    }

    // Handling the BLIK form submission
    document.getElementById('blik-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting to a server
        // Simulate success
        setTimeout(function () {
            alert("Transakcja BLIK zakończona pomyślnie!");
            closeBlikPopup(); // Close the BLIK popup after success
        }, 1000); // Simulate a 1-second transaction delay
        document.getElementById('blik-form').submit();
    });

    document.querySelector('.primary-button').addEventListener('click', function (event) {
        event.preventDefault();
        showPaymentPopup();
    });
</script>