<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add, remove, and display actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'remove') {
        $index = intval($_POST['index']);
        if (isset($_SESSION['cart'][$index])) {
            // Remove the item from the cart
            unset($_SESSION['cart'][$index]);

            // Re-index the cart to ensure consistent indexes
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
}

$cart = $_SESSION['cart'];

?>

<div class="main-container">
    <div class="cart">
        <?php if (!$is_logged_in): ?>
            <h1>Proszę się zalogować, aby zobaczyć koszyk</h1>
        <?php else: ?>
            <div class="cart-container">
                <h1>Twój Koszyk</h1>
                <?php if (empty($cart)): ?>
                    <p>Twój koszyk jest pusty.</p>
                <?php else: ?>
                    <?php foreach ($cart as $index => $item): ?>
                    <div class="cart-elem">
                        <strong>Samochód:</strong> <?php echo htmlspecialchars($item['vehicleId']); ?> <br>
                        <ul>
                            <strong>Odbiór:</strong> <?php echo htmlspecialchars($item['pickUpLocation']); ?> <br>
                            <strong>Zwrot:</strong> <?php echo htmlspecialchars($item['dropOffLocation']); ?> <br>
                            <strong>Od:</strong> <?php echo htmlspecialchars($item['rentalDateStart']); ?> <br>
                            <strong>Do:</strong> <?php echo htmlspecialchars($item['rentalDateEnd']); ?> <br>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit" class="secondary-button">Usuń</button>
                            </form>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

