<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxDrive</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search"/>
</head>
<body>
<?php
$page = $_GET['page'] ?? 'home';
$base_url = '/public/index.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<header>
    <img src="../public/assets/images/logo-transparent.png" alt="logo">
    <nav>
        <ul>
            <li><a href="<?php echo $base_url; ?>?page=home"
                   class="<?php echo $page === 'home' ? 'active' : ''; ?> underline-hover">STRONA GŁÓWNA</a></li>
            <li><a href="<?php echo $base_url; ?>?page=cars"
                   class="<?php echo $page === 'cars' ? 'active' : ''; ?> underline-hover">NASZA FLOTA</a></li>
            <li><a href="<?php echo $base_url; ?>?page=contact"
                   class="<?php echo $page === 'contact' ? 'active' : ''; ?> underline-hover">KONTAKT</a></li>
        </ul>
    </nav>

    <div class="icons-container">
        <a href="<?php echo $base_url; ?>?page=cart"> <img src="../public/assets/icons/shopping_cart.svg" alt="cart"></a>
        <a href="<?php echo $base_url; ?>?page=login"> <img src="../public/assets/icons/user.svg" alt="user"></a>
    </div>
</header>
