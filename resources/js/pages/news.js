import { initCommon } from '../core/common.js';
import { initFilters } from '../components/filters.js';
import { initLoadMore } from '../components/loadMore.js';

function init() {
  const filters = Array.from(document.querySelectorAll('[data-gallery-filters] [data-filter]'));
  const items = Array.from(document.querySelectorAll('[data-listing="news"] [data-category]'));
  const countEl = document.querySelector('.listing-count');
  initFilters({ filters, items, countEl });
  initLoadMore();

  initCommon();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
