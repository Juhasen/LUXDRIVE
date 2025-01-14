document.addEventListener('DOMContentLoaded', function () {
    // Get the form and the submit button
    const form = document.getElementById('rental-form');
    const submitButton = document.getElementById('submit-button');
    const errorMessages = document.querySelectorAll('.error-message');
    const priceSummaryBox = document.querySelector('.price-summary-box'); // Price summary box

    // Function to check if all form inputs are filled
    function checkFormValidity() {
        let isValid = true;
        errorMessages.forEach((error) => {
            error.style.display = 'none'; // Hide error messages initially
        });

        // Loop through each form input to check if required fields are filled
        const requiredFields = form.querySelectorAll('input[required], select[required]');
        requiredFields.forEach((input) => {
            if (!input.value || input.value.trim() === '') {
                isValid = false;
                // Find the associated error message and show it
                const errorMessage = document.getElementById(input.id + '-error');
                if (errorMessage) {
                    // Display the error message
                    errorMessage.style.display = 'block';

                    // Hide the error message after 2 seconds
                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 2000); // 2000ms = 2 seconds
                }
            }
        });

        // Show the price summary box if the form is valid
        if (isValid) {
            priceSummaryBox.classList.add('show');  // Show price summary box
        } else {
            if(priceSummaryBox.classList.contains('show')) {
                priceSummaryBox.classList.remove('show'); // Hide price summary box if form is invalid
            }
        }

        return isValid;
    }

    // Add event listener to submit button
    submitButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form from submitting immediately

        if (checkFormValidity()) {
            // If the form is valid, submit it programmatically
            form.submit();
        } else {
            console.log('Please fill all required fields');
        }
    });

    // Optional: Add real-time validation for input fields
    form.addEventListener('input', function () {
        checkFormValidity();
    });
});