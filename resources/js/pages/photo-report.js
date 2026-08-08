import { initCommon } from '../core/common.js';
import { initLightbox } from '../components/lightbox.js';

function init() {
  const items = Array.from(document.querySelectorAll('[data-gallery] .photo-gallery__item'));
  initLightbox(items);

  initCommon();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
