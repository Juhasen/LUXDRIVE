<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: http://localhost:63342/LUXDRIVE/public/index.php?page=profile");
    exit;
}
?>


<section class="login-container">
    <div class="login-background">
        <!-- Login Form -->
        <div class="form-container">
            <form action="../controllers/login.php" class="register-form" method="post">
                <div class="form-group">
                    <input type="email" id="log-email" name="email" placeholder=" " required>
                    <label for="log-email">E-mail</label>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder=" " required>
                    <label for="password">Hasło</label>
                    <button type="button" class="eye-button" id="toggle-password">
                        <img src="../public/assets/icons/eye-icon.png" alt="Show password">
                    </button>
                </div>
                <h4 class="form-info">Nie masz konta? <a href="http://localhost:63342/LUXDRIVE/public/index.php?page=register">Zarejestruj się</a></h4>
                <button type="submit" class="submit-button primary-button">Zaloguj się</button>

            </form>
        </div>
    </div>

</section>

<script src="../public/login-register.js" defer></script>