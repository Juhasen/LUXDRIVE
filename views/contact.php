<section class="main-container">
    <div class="contact-container">
        <h2>Skontakuj się</h2>
        <p>Jesteśmy tutaj, aby pomóc! Skontaktuj się z nami w sprawie zapytań lub wsparcia.</p>

        <div class="contact-info">
            <h3>Nasze Biuro</h3>
            <p>Adres: Piotrkowska 123, 90-001, Łódź</p>
            <p>Telefon: +48 692 187 092</p>
            <p>Email: wsparcie@luxdrive.pl</p>
            <p>Godziny otwarcia: Poniedziałek - Piątek: 9:00 - 18:00</p>
        </div>

        <form class="contact-form" action="../controllers/send_message.php" method="POST">
            <h3>Wyślij wiadomość</h3>
            <div class="form-group">
                <label for="name">Twoje Imię</label>
                <input type="text" id="name" name="name" placeholder="Wprowadź swoje imię" required>
            </div>
            <div class="form-group">
                <label for="email">Twój E-mail</label>
                <input type="email" id="email" name="email" placeholder="Wprowadź swój e-mail" required>
            </div>
            <div class="form-group">
                <label for="message">Twoja Wiadomość</label>
                <textarea id="message" name="message" rows="5" placeholder="Napisz tutaj swoją wiadomość" required></textarea>
            </div>
            <button type="submit" class="submit-button">Wyślij wiadomość</button>
        </form>
    </div>
</section>

