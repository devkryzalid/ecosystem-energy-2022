import Swiper, { Navigation } from 'swiper';

Swiper.use([Navigation]);

// Apply Swiper mechanics to all single-image sliders
document.querySelectorAll('.gutenberg-slider-single').forEach((el, index) => {
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
document.querySelectorAll('.gutenberg-slider-multiple').forEach((el, index) => {
  const innerContainer = el.querySelector('.slider-container');
  const id = 'slider-multiple-' + index;
  innerContainer.setAttribute('id', id);
  const swiperContainer = innerContainer.querySelector('.swiper-container');
  const slider = new Swiper(swiperContainer, {
    speed: 300,
    loop: false,
    slidesPerView: 1,
    spaceBetween: 30,
    navigation: { nextEl: `#${id} .next`, prevEl: `#${id} .prev` },
    breakpoints: {
      768: { slidesPerView: 3 },
      500: { slidesPerView: 2 },
    }
  });

  const modal = el.querySelector('.gutenberg-slider-modal');
  const modalId = 'modal-slider-' + index;
  modal.setAttribute('id', modalId);

  modal.querySelector('.overlay').addEventListener('click', () => document.body.classList.remove('modal-open'));
  modal.querySelector('.slider-close').addEventListener('click', () => document.body.classList.remove('modal-open'));
  
  const modalSwiperContainer = modal.querySelector('.swiper-container');
  const modalSlider = new Swiper(modalSwiperContainer, {
    speed: 300,
    loop: false,
    slidesPerView: 1,
    spaceBetween: 60,
    navigation: { nextEl: `#${modalId} .next`, prevEl: `#${modalId} .prev` }
  });

  swiperContainer.querySelectorAll('.swiper-slide.static').forEach(e => {
    e.addEventListener('click', () => {
      document.body.classList.add('modal-open');
    })
  });

  slider.on('click', e => { modalSlider.slideTo(e.clickedIndex); });
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
