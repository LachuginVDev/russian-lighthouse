import '../../styles/main.scss';

import { initCommon } from '../core/common.js';
import { initFilters } from '../components/filters.js';

function init() {
  const filters = Array.from(document.querySelectorAll('[data-gallery-filters] [data-filter]'));
  const items = Array.from(document.querySelectorAll('[data-listing="photos"] [data-category]'));
  const countEl = document.querySelector('.listing-count');
  initFilters({ filters, items, countEl });

  initCommon();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
