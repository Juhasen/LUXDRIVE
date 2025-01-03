<?php

session_start();

session_unset();
session_destroy();


header("Location: https://luxdrive.pl/public/index.php?page=home");
exit;
