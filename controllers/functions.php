<?php
/**
 * @param $result
 *
 * @return void
 */
function generateCarCards($result): void
{
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $gearbox = $row['gearbox_type'] == 1 ? 'Automat' : 'Manual';

            echo '
                <div class="car-card">
                    <img src="../public/assets/images/' . htmlspecialchars($row['image']) . '"
                         alt="' . htmlspecialchars($row['make']) . '" class="car-image"/>
                    <div class="car-info">
                        <div class="car-specs">
                            <h2 class="car-name">' . htmlspecialchars($row['make']) . ' ' . htmlspecialchars($row['model']) . '</h2>
                            <div class="car-details">
                                <span class="detail-icon">
                                    <img src="../public/assets/icons/car-seat.png" alt="Seats"> ' . htmlspecialchars($row['seats']) . '
                                </span>
                                <span class="detail-icon">
                                    <img src="../public/assets/icons/gearbox.png" alt="Gearbox"> ' . htmlspecialchars($gearbox) . '
                                </span>
                                <span class="detail-icon">
                                    <img src="../public/assets/icons/luggage.png" alt="Luggage"> ' . htmlspecialchars($row['luggage']) . '
                                </span>
                                <span class="detail-icon">
                                    <img src="../public/assets/icons/calendar.png" alt="Year"> ' . htmlspecialchars($row['year']) . '
                                </span>
                            </div>
                        </div>
                        <div class="car-price">
                            <button class="primary-button">Detale</button>
                            <span class="price">' . number_format($row['price'], 0) . 'zł <small>/Doba</small></span>
                        </div>
                    </div>
                </div>
                ';
        }
    } else {
        echo '<p>No cars available.</p>';
    }
}