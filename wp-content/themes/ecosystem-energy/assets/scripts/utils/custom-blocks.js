import Swiper, { Navigation } from 'swiper';

Swiper.use([Navigation]);

// Apply Swiper mechanics to all image sliders
document.querySelectorAll('.content-slider-ctn').forEach((el, index) => {
  const id = 'slider-' + index;
  el.setAttribute('id', id);
  const swiperContainer = el.querySelector('.swiper-container');
  const slider = new Swiper(swiperContainer, {
      speed: 300,
      loop: true,
      navigation: { nextEl: `#${id} .next`, prevEl: `#${id} .prev`, }
  });
});

// Apply Swiper mechanics to all multiple-image sliders
document.querySelectorAll('.content-slider-multiple-ctn').forEach((el, index) => {
  const id = 'slider-multiple-' + index;
  el.setAttribute('id', id);
  const swiperContainer = el.querySelector('.swiper-container');
  const slider = new Swiper(swiperContainer, {
      speed: 300,
      loop: true,
      slidesPerView: 3,
      spaceBetween: 40,
      navigation: { nextEl: `#${id} .next`, prevEl: `#${id} .prev` }
  });
});

// Apply accordion mechanics to all Accordions
document.querySelectorAll('.content-accordion-ctn').forEach((el, index) => {
  el.setAttribute('id', 'accordion-' + index);

  const title = el.querySelector('.title');
  el.style.height = title.offsetHeight + 'px';

  title.addEventListener('click', ({ target }) => {
    const parent = target.parentElement
    const content = parent.querySelector('.content');

    if (parent.classList.contains('open')) {
      parent.classList.remove('open');
      parent.style.height = target.offsetHeight + 'px';

    } else {
      parent.classList.add('open');
      parent.style.height = target.offsetHeight + content.offsetHeight + 'px';
    }
  });
});
