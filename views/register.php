<?php
require_once '../controllers/constants.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: " . BASE_REDIRECT_URL . "profile");
    exit;
}
?>

<section class="login-container">
    <div class="login-background">
        <!-- Register Form -->
        <div class="form-container">
            <form action="../controllers/register.php" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="name" name="name" placeholder=" " required>
                        <label for="name">Imię*</label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="surname" name="surname" placeholder=" " required>
                        <label for="surname">Nazwisko*</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder=" " required>
                        <label for="email">Adres email*</label>
                    </div>
                    <div class="form-group">
                        <input type="tel" id="phone-number" name="phone_number" placeholder=" " required>
                        <label for="phone-number">Numer telefonu*</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group password-group">
                        <input type="password" id="password" name="password" placeholder=" " required>
                        <label for="password">Hasło*</label>
                        <button type="button" class="eye-button" id="toggle-password">
                            <img src="../public/assets/icons/eye-icon.png" alt="Show password">
                        </button>
                    </div>
                    <div class="form-group password-group">
                        <input type="password" id="confirm-password" name="confirm_password" placeholder=" " required>
                        <label for="confirm-password">Potwierdź hasło*</label>
                        <button type="button" class="eye-button" id="toggle-confirm-password">
                            <img src="../public/assets/icons/eye-icon.png" alt="Show password">
                        </button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="country" name="country" placeholder=" " required>
                        <label for="country">Kraj*</label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="city" name="city" placeholder=" " required>
                        <label for="city">Miasto*</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="street" name="street" placeholder=" " required>
                        <label for="street">Ulica*</label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="apartment" name="apartment" placeholder=" " required>
                        <label for="apartment">Numer posesji / mieszkania*</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="postal-code" name="postal_code" placeholder=" " required>
                        <label for="postal-code">Kod pocztowy*</label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="license-number" name="license_number" placeholder=" " required>
                        <label for="license-number">Numer prawa jazdy*</label>
                    </div>
                </div>
                <div class="register-buttons">
                    <button class="submit-button primary-button">Zarejestruj się</button>
                    <button class="back-to-login secondary-button">
                        <a href="https://luxdrive.pl/public/index.php?page=login">Powrót do logowania</a>
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>


<script src="../public/login-register.js" defer></script>
