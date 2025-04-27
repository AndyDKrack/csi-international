// Open Lightbox when image is clicked
const lightboxes = document.querySelectorAll('.lightbox');
const closeBtns = document.querySelectorAll('.close-btn');

lightboxes.forEach(lightbox => {
    lightbox.style.display = 'none';
});

document.querySelectorAll('.photo-item a').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = link.getAttribute('href');
        document.querySelector(targetId).style.display = 'flex';
    });
});

// Close Lightbox when close button is clicked
closeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        btn.closest('.lightbox').style.display = 'none';
    });
});

// Close Lightbox when anywhere on the screen is clicked
window.addEventListener('click', (e) => {
    if (e.target.classList.contains('lightbox')) {
        e.target.style.display = 'none';
    }
});
