let currentIndex = 0;
const slides = document.querySelectorAll('.background');
const totalSlides = slides.length;

// Set the first slide to active on load
slides[currentIndex].classList.add('active');

function showNextSlide() {
  // Save the current index before updating
  const previousIndex = currentIndex;

  // Remove the active class and add the previous class to the current slide
  slides[currentIndex].classList.remove('active');
  slides[currentIndex].classList.add('previous');

  // Update the currentIndex to the next slide
  currentIndex = (currentIndex + 1) % totalSlides;

  // Add the active class to the new slide
  slides[currentIndex].classList.add('active');

  // Remove the previous class from the old slide after a transition delay
  setTimeout(() => {
    slides[previousIndex].classList.remove('previous');
  }, 1500); // ustawić tyle ile trwa animacja
}

// Run the function at intervals
setInterval(showNextSlide, 4000);
