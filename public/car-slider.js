let carSlider = document.querySelector('.car-slider');
let nextButton = document.querySelector('.next');
let prevButton = document.querySelector('.prev');

nextButton.onclick = () => {
    carSlider.append(carSlider.firstElementChild);
}

prevButton.onclick = () => {
    carSlider.prepend(carSlider.lastElementChild);
}