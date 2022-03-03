import Swiper, { Navigation } from 'swiper';

Swiper.use([Navigation]);

const container = document.querySelector('.slider').querySelector('.swiper-container');
const slider = new Swiper(container, {
    speed: 300,
    loop: false,
    slidesPerView: 5,
    spaceBetween: 30,
    navigation: { nextEl: `.next`, prevEl: `.prev` }
});
