import Swiper, { Navigation } from 'swiper';

Swiper.use([Navigation]);

const container = document.querySelector('.case-studies-slider-ctn').querySelector('.swiper-container');
const slider = new Swiper(container, {
    speed: 300,
    loop: false,
    slidesPerView: 5,
    spaceBetween: 30,
    navigation: { nextEl: `.case-studies-slider-ctn .next`, prevEl: `.case-studies-slider-ctn .prev` }
});
