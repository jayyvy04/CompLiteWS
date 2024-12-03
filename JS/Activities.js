'use strict';

// Header scroll animation
const header = document.querySelector('.header-bottom');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll > lastScroll && currentScroll > 100) {
        header.classList.add('hide');
    } else {
        header.classList.remove('hide');
    }
    
    lastScroll = currentScroll;
});

// Card reveal animation
const cards = document.querySelectorAll('.activity-card');
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const cardObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            entry.target.style.animationDelay = `${index * 0.2}s`;
            entry.target.classList.add('card-animate');
            cardObserver.unobserve(entry.target);
        }
    });
}, observerOptions);

cards.forEach(card => {
    cardObserver.observe(card);
});