<?php
include_once '../config/database.php';

include_once '../includes/header.php';

$page = $_GET['page'] ?? 'home';
$allowed_pages = ['home', 'cars', 'contact', 'loginForm', 'register', 'profile'];

if (in_array( $page, $allowed_pages)) {
    include("../views/{$page}.php");
} else {
    include("../views/home.php");
}

include_once '../includes/footer.php';