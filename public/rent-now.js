document.addEventListener('DOMContentLoaded', () => {
    const rentalDateStartInput = document.getElementById('rental-date-start');
    const rentalDateEndInput = document.getElementById('rental-date-end');

    if (rentalDateStartInput && rentalDateEndInput) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
        const day = String(now.getDate()).padStart(2, '0');

        const currentDate = `${year}-${month}-${day}`;

        rentalDateStartInput.min = currentDate;
        rentalDateStartInput.value = currentDate;
        rentalDateStartInput.max = `${year + 1}-${month}-${day}`;
        rentalDateStartInput.placeholder = currentDate;

        // Calculate one day later
        const tomorrow = new Date(now);
        tomorrow.setDate(now.getDate() + 1); // Add one day
        const nextYear = tomorrow.getFullYear();
        const nextMonth = String(tomorrow.getMonth() + 1).padStart(2, '0');
        const nextDay = String(tomorrow.getDate()).padStart(2, '0');
        const nextDate = `${nextYear}-${nextMonth}-${nextDay}`;

        rentalDateEndInput.min = nextDate;
        rentalDateEndInput.value = nextDate;
        rentalDateEndInput.max = `${nextYear}-${nextMonth + 1}-${nextDay}`;
        rentalDateEndInput.placeholder = nextDate;
    }
});


const selectWrappers = document.querySelectorAll('.custom-select .select-wrapper');
selectWrappers.forEach(selectWrapper => {
    selectWrapper.addEventListener('click', () => {
        selectWrapper.closest('.custom-select').classList.toggle('open');
    });
});

const selectItems = document.querySelectorAll('.custom-select .select-option');
selectItems.forEach(item => {
    item.addEventListener('click', () => {
        const selectedValue = item.getAttribute('data-value');
        item.closest('.custom-select').querySelector('.selected-option').textContent = item.textContent;
        item.closest('.custom-select').classList.remove('open');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const customSelects = document.querySelectorAll('.custom-select');

    customSelects.forEach(select => {
        const selectedOption = select.querySelector('.selected-option');
        const options = select.querySelectorAll('.select-option');
        const hiddenInput = select.nextElementSibling; // Get the hidden input field.

        options.forEach(option => {
            option.addEventListener('click', () => {
                const value = option.getAttribute('data-value'); // Get the selected value.
                selectedOption.textContent = option.textContent.trim(); // Update the visible selection.
                hiddenInput.value = value; // Update the hidden input value.
            });
        });
    });
});