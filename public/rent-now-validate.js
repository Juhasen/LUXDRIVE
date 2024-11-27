document.getElementById('rental-form').addEventListener('submit', function(event) {
    let isValid = true;

    // Validate car type
    const carType = document.getElementById('car-type').value;
    const carTypeError = document.getElementById('car-type-error');
    if (!carType) {
        carTypeError.style.display = 'block';
        isValid = false;
        hideErrorAfterDelay(carTypeError);
    } else {
        carTypeError.style.display = 'none';
    }

    // Validate pick-up location
    const pickUpLocation = document.getElementById('pick-up-location').value;
    const pickUpError = document.getElementById('pick-up-location-error');
    if (!pickUpLocation) {
        pickUpError.style.display = 'block';
        isValid = false;
        hideErrorAfterDelay(pickUpError);
    } else {
        pickUpError.style.display = 'none';
    }

    // Validate drop-off location
    const dropOffLocation = document.getElementById('drop-off-location').value;
    const dropOffError = document.getElementById('drop-off-location-error');
    if (!dropOffLocation) {
        dropOffError.style.display = 'block';
        isValid = false;
        hideErrorAfterDelay(dropOffError);
    } else {
        dropOffError.style.display = 'none';
    }

    if (!isValid) {
        event.preventDefault();
    }
});

// Function to hide error message after 3 seconds
function hideErrorAfterDelay(element) {
    setTimeout(() => {
        element.style.display = 'none';
    }, 3000);
}
