import Swiper, { Navigation } from 'swiper';

Swiper.use([Navigation]);

const container = document.querySelector('.home-slider').querySelector('.swiper-container');
const slider = new Swiper(container, {
    speed: 300,
    loop: false,
    slidesPerView: 1,
    spaceBetween: 30,
    navigation: { nextEl: '.next', prevEl: '.prev' },
    breakpoints: {
      992: { slidesPerView: 4 },
      768: { slidesPerView: 3 },
      500: { slidesPerView: 2 },
    }
});

// Initialize rotating animation for hero
const spinner = document.getElementById('home-spinner');
if (spinner) {
  const speed = 0.1;
  const timer = 10;

  let rotation = 0;

  setInterval(() => {
    rotation = rotation > 360 ? 0 : (rotation + speed);
    spinner.style.transform = 'rotate(' + rotation + 'deg)'; 
  }, timer)
}

// Add listener to scroll button
const scrollToContent = document.getElementById('scroll-to-content');
const scrollTarget = document.getElementById('scroll-content');
scrollToContent.addEventListener('click', () => scrollTarget.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'start' }))

// Yellow overlay mechanics
window.scrollTo({ top: 0 });
setTimeout(() => { document.querySelector('.page-container').classList.remove('overlay'); }, 1000);