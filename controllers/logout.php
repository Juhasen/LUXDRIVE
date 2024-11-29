<?php

session_start();

session_unset();
session_destroy();


header("Location: http://localhost:63342/LUXDRIVE/public/index.php?page=home");
exit;
