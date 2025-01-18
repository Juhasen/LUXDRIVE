<?php

require_once '../controllers/functions.php';

$rentals = get_all_rentals_from_the_newest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept'])) {
        $rental_id = $_POST['accept'];
        accept_rental($rental_id);
        header('Location: https://luxdrive.pl/public/index.php?page=rentals');
    } elseif (isset($_POST['reject'])) {
        $rental_id = $_POST['reject'];
        reject_rental($rental_id);
        header('Location: https://luxdrive.pl/public/index.php?page=rentals');
    }
}
?>


<div class="rentals-main-container">
    <h1>Rezerwacje samochodów</h1>
    <div class="rentals">
        <div class="rentals-container">
            <?php foreach ($rentals as $rental): ?>
                <div class="rental">
                    <?php displayCarImage($rental['vehicle_id']); ?>
                    <div class="rental-info">
                        <h2><?php displayVehicleName($rental['vehicle_id']); ?></h2>
                        <p>
                            <span class="highlight">Email:</span> <?php displayEmail($rental['user_id']) ?>
                        </p>
                        <p>
                            <span class="highlight">Data Rozpoczęcia:</span> <?php echo trim(htmlspecialchars($rental['start_date'])); ?>
                        </p>
                        <p>
                            <span class="highlight">Data Zakończenia:</span> <?php echo trim(htmlspecialchars($rental['end_date'])); ?>
                        </p>
                        <p>
                            <span class="highlight">Odbiór:</span> <?php echo trim(htmlspecialchars($rental['pick_up_location'])); ?>
                        </p>
                        <p>
                            <span class="highlight">Zwrot:</span> <?php echo trim(htmlspecialchars($rental['drop_off_location'])); ?>
                        </p>
                        <p>
                            <?php
                            $status = trim($rental['isAccepted']);
                            ?>
                            <span>Stan rezerwacji:</span>
                            <span class="
                                <?php
                            if ($status === 'Oczekuje na potwierdzenie') {
                                echo 'pending-status';
                            } elseif ($status === 'Potwierdzona') {
                                echo 'accepted-status';
                            } elseif ($status === 'Nie potwierdzona') {
                                echo 'rejected-status';
                            } else {
                                echo 'default';
                            }
                            ?>
                                     ">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                        </p>
                        <?php
                        if ($status === 'Oczekuje na potwierdzenie'): ?>
                        <form method="POST" action="" class="button-form">
                            <button class="primary-button" type="submit" name="accept" value="<?php echo $rental['id']; ?>">Akceptuj</button>
                            <button class="delete-button" type="submit" name="reject" value="<?php echo $rental['id']; ?>">Odrzuć</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
