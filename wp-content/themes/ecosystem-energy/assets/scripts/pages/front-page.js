import Swiper, { Navigation } from 'swiper';

Swiper.use([Navigation]);

const container = document.querySelector('.slider-ctn').querySelector('.swiper-container');
const slider = new Swiper(container, {
    speed: 300,
    loop: false,
    slidesPerView: 4,
    spaceBetween: 30,
    navigation: { nextEl: `.next`, prevEl: `.prev` }
});



const spinner = document.getElementById('home-spinner');

let rotation = 0;
let mod = 0;
let spd = 0;

// window.addEventListener('mousemove', e => {
//   const deg = Math.pow(e.clientX, 1/8);
//   mod = deg;
// })

setInterval(() => {
  // console.log(mod);
  // if (mod > 0) mod -= 0.03;
  spinner.style.transform = 'rotate(' + rotation + 'deg)'; 
  rotation += (0.1 + mod);
}, 10)