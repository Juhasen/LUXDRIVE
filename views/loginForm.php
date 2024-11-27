<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: http://localhost:63342/IAB/public/index.php?page=profile");
    exit;
}
?>



<section class="main-container login-container">

    <button class="login-button primary-button">Logowanie</button>
    <div class="car-container">
        <img src="../public/assets/images/loginFormCarV2.png" width="920" height="531" alt="Car" class="car-image">
    </div>
    <!-- Login Form -->
    <div class="form-container login-form hidden">
        <form action="../controllers/login.php" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <label for="log-email"></label><input type="email" id="log-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Hasło</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-button primary-button">Zaloguj się</button>
        </form>
    </div>

    <!-- Register Form -->
    <div class="form-container register-form hidden">
        <form action="../controllers/register.php" method="post">
            <div class="form-group">
                <label for="name">Imię</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <label for="reg-email"></label><input type="email" id="reg-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Hasło</label>
                <label for="reg-password"></label><input type="password" id="reg-password" name="password" required>
            </div>
            <button type="submit" class="submit-button primary-button">Zarejestruj się</button>
        </form>
    </div>
    <button class="register-button secondary-button">Rejestracja</button>

    <button class="secondary-button back-button hidden">&larr; Powrót</button>
</section>

<script src="../public/login-register.js" defer></script>