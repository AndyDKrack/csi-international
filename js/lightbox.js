// Open Lightbox when image is clicked
const lightboxes = document.querySelectorAll('.lightboxabout');
const closeBtns = document.querySelectorAll('.close-btn1');

// Initially hide all lightboxes
lightboxes.forEach(lightbox => {
    lightbox.style.display = 'none';
});

// Open the lightbox when clicking on any image link
document.querySelectorAll('.certificates a').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = link.getAttribute('href');
        const targetLightbox = document.querySelector(targetId);
        targetLightbox.style.display = 'flex';
    });
});

// Close Lightbox when close button is clicked
closeBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevents triggering the window click event
        const lightbox = btn.closest('.lightboxabout');
        lightbox.style.display = 'none';
    });
});

// Close Lightbox when anywhere on the screen (outside the lightbox) is clicked
window.addEventListener('click', (e) => {
    lightboxes.forEach(lightbox => {
        // Close the lightbox if clicked outside of the content area
        if (e.target === lightbox) {
            lightbox.style.display = 'none';
        }
    });
});
