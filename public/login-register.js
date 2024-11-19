const mainContainer = document.querySelector('.main-container');
const loginButton = document.querySelector('.login-button');
const registerButton = document.querySelector('.register-button');
const backButton = document.querySelector('.back-button');
const loginForm = document.querySelector('.login-form');
const registerForm = document.querySelector('.register-form');

// Handle Logowanie button click
loginButton.addEventListener('click', () => {
    if (loginForm.classList.contains('hidden')) {
        loginForm.classList.remove('hidden'); // Show login form
        registerForm.classList.add('hidden'); // Hide register form
        mainContainer.classList.add('move-login');
        loginButton.classList.add('hidden'); // Hide Logowanie button
        registerButton.classList.add('hidden'); // Hide Rejestracja button
        backButton.classList.remove('hidden'); // Show back button
    }
});

// Handle Rejestracja button click
registerButton.addEventListener('click', () => {
    if (registerForm.classList.contains('hidden')) {
        registerForm.classList.remove('hidden'); // Show register form
        loginForm.classList.add('hidden'); // Hide login form
        mainContainer.classList.add('move-register');
        loginButton.classList.add('hidden'); // Hide Logowanie button
        registerButton.classList.add('hidden'); // Hide Rejestracja button
        backButton.classList.remove('hidden'); // Show back button
    }
});

// Handle Powrót button click
backButton.addEventListener('click', () => {
    if(mainContainer.classList.contains('move-login')) {
        mainContainer.classList.remove('move-login');
    }
    if(mainContainer.classList.contains('move-register')) {
        mainContainer.classList.remove('move-register');
    }
    loginForm.classList.add('hidden'); // Hide login form
    registerForm.classList.add('hidden'); // Hide register form
    loginButton.classList.remove('hidden'); // Show Logowanie button
    registerButton.classList.remove('hidden'); // Show Rejestracja button
    backButton.classList.add('hidden'); // Hide back button
});
