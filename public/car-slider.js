let carSlider = document.querySelector('.car-slider');
let nextButton = document.querySelector('.next');
let prevButton = document.querySelector('.prev');

// Function to add a smooth transition effect
function slide(direction) {
    // Add transition class to car-slider and set initial opacity
    carSlider.style.transition = 'transform 0.8s ease-in-out, opacity 0.8s ease-in-out';
    carSlider.style.opacity = '0'; // Lower the opacity during transition

    if (direction === 'next') {
        // Move slider to the left (next slide)
        carSlider.style.transform = 'translateX(80%)';

        // After transition, append the first element to the end
        setTimeout(() => {
            carSlider.append(carSlider.firstElementChild);
            carSlider.style.transition = 'none'; // Disable transition to avoid flickering
            carSlider.style.transform = 'translateX(0)'; // Reset position
            carSlider.style.opacity = '1'; // Reset opacity
        }, 800); // Match the transition duration (500ms)
    } else if (direction === 'prev') {
        // Move slider to the right (previous slide)
        carSlider.style.transform = 'translateX(-80%)';

        // After transition, prepend the last element to the beginning
        setTimeout(() => {
            carSlider.prepend(carSlider.lastElementChild);
            carSlider.style.transition = 'none'; // Disable transition to avoid flickering
            carSlider.style.transform = 'translateX(0)'; // Reset position
            carSlider.style.opacity = '1'; // Reset opacity
        }, 800); // Match the transition duration (500ms)
    }
}

nextButton.onclick = () => {
    slide('next');
};

prevButton.onclick = () => {
    slide('prev');
};
