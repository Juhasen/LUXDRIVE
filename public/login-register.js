document.addEventListener("DOMContentLoaded", function() {
    // Get the eye buttons and input fields
    const togglePassword = document.getElementById("toggle-password");
    const passwordInput = document.getElementById("password");
    const toggleConfirmPassword = document.getElementById("toggle-confirm-password");
    const confirmPasswordInput = document.getElementById("confirm-password");

    // Only add event listener if the elements are present
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener("click", function() {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            // Toggle the eye icon depending on the input type
            togglePassword.querySelector("img").src = type === "password" ? "../public/assets/icons/eye-icon.png" : "../public/assets/icons/eye-icon-open.png";
        });
    }

    if (toggleConfirmPassword && confirmPasswordInput) {
        toggleConfirmPassword.addEventListener("click", function() {
            const type = confirmPasswordInput.type === "password" ? "text" : "password";
            confirmPasswordInput.type = type;
            // Toggle the eye icon depending on the input type
            toggleConfirmPassword.querySelector("img").src = type === "password" ? "../public/assets/icons/eye-icon.png" : "../public/assets/icons/eye-icon-open.png";
        });
    }
});
