import Swiper, { Navigation } from 'swiper';

Swiper.use([Navigation]);

const container = document.querySelector('.industry-cs-slider').querySelector('.swiper-container');
const slider = new Swiper(container, {
    speed: 300,
    loop: false,
    slidesPerView: 1,
    spaceBetween: 0,
    navigation: { nextEl: `.next`, prevEl: `.prev` },
    breakpoints: {
      992: {
        slidesPerView: 4
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 30
      },
    }
});
