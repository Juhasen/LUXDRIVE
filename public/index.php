<?php
include_once '../config/database.php';

include_once '../includes/header.php';

$page = $_GET['page'] ?? 'home';
$page = isset($_GET['page']) ? explode('?', $_GET['page'])[0] : 'home';
$allowed_pages = ['home', 'cars', 'contact', 'login', 'register', 'profile', 'rent_car', 'cart', 'admin', 'edit_car', 'add_car'];

if (in_array($page, $allowed_pages)) {
    include("../views/{$page}.php");
} else {
    include("../views/home.php");
}

include_once '../includes/footer.php';