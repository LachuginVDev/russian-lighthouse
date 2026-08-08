import { initFilters } from './filters.js';
import { initLightbox } from './lightbox.js';

export function initPhotoGallery() {
  const gallery = document.querySelector('[data-gallery]');
  if (!gallery) return;

  const filters = Array.from(document.querySelectorAll('[data-gallery-filters] [data-filter]'));
  const items = Array.from(gallery.querySelectorAll('[data-category]'));

  initFilters({ filters, items });
  initLightbox(items);
}
