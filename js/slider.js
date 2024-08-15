// script.js
let slideIndex = 0;
const slides = document.querySelector('.slides');
const slideWidth = document.querySelector('.slides img').clientWidth; // Width of a single slide
const totalSlides = slides.children.length;

// Function to show the current slide
function showSlide(index) {
    if (index >= totalSlides) {
        slideIndex = 0;
    } else if (index < 0) {
        slideIndex = totalSlides - 1;
    } else {
        slideIndex = index;
    }
    slides.style.transform = `translateX(${-slideIndex * slideWidth}px)`; // Use pixel values for translation
}

// Event listeners for navigation buttons
document.querySelector('.prev').addEventListener('click', () => {
    showSlide(slideIndex - 1);
});

document.querySelector('.next').addEventListener('click', () => {
    showSlide(slideIndex + 1);
});

// Optional: Automatic slide transition
setInterval(() => {
    showSlide(slideIndex + 1);
}, 3000); // Change slide every 3 seconds