<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie danych z formularza
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Walidacja danych
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // Ustawienia wiadomości
        $to = "juszczyk-krystian@wp.pl"; // Adres e-mail, na który będzie wysyłana wiadomość
        $subject = "Nowa wiadomość kontaktowa od $name";
        $body = "Imię: $name\nE-mail: $email\n\nWiadomość:\n$message";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Wysyłanie wiadomości e-mail
        if (mail($to, $subject, $body, $headers)) {
            echo "Twoja wiadomość została wysłana!";
        } else {
            echo "Wystąpił problem podczas wysyłania wiadomości. Prosimy spróbować ponownie później.";
        }
    } else {
        echo "Proszę wypełnić wszystkie pola formularza poprawnie.";
    }
}