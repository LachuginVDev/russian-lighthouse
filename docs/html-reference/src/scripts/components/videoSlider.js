import Swiper from 'swiper';
import { Navigation, Keyboard, A11y } from 'swiper/modules';
import 'swiper/css';

export function initVideoSlider() {
  const el = document.querySelector('[data-video-slider]');
  if (!el) return;

  return new Swiper(el, {
    modules: [Navigation, Keyboard, A11y],
    slidesPerView: 1.15,
    spaceBetween: 20,
    keyboard: { enabled: true },
    a11y: { enabled: true },
    breakpoints: {
      576: { slidesPerView: 1.6 },
      768: { slidesPerView: 2.2 },
      1024: { slidesPerView: 3.1 },
    },
  });
}
