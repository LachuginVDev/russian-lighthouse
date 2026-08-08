import { initCommon } from '../core/common.js';
import { initFilters } from '../components/filters.js';
import { initVideoModal } from '../components/videoModal.js';

function init() {
  const filters = Array.from(document.querySelectorAll('[data-gallery-filters] [data-filter]'));
  const items = Array.from(document.querySelectorAll('[data-listing="video"] [data-category]'));
  const countEl = document.querySelector('.listing-count');
  initFilters({ filters, items, countEl });
  initVideoModal();

  initCommon();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
