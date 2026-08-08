import { gsap } from '../core/gsap.js';

export function initFilters({ filters, items, allValue = 'all', countEl = null } = {}) {
  if (!filters?.length || !items?.length) return;

  const updateCount = (visible) => {
    if (!countEl) return;
    const label = countEl.dataset.countLabel || 'элементов';
    countEl.textContent = `${visible} ${label}`;
  };

  filters.forEach((filter) => {
    filter.addEventListener('click', () => {
      filters.forEach((f) => {
        f.classList.remove('is-active');
        f.setAttribute('aria-selected', 'false');
      });
      filter.classList.add('is-active');
      filter.setAttribute('aria-selected', 'true');

      const category = filter.dataset.filter;
      let visible = 0;

      items.forEach((item) => {
        const matches = category === allValue || item.dataset.category === category;
        if (matches) {
          item.style.display = '';
          visible += 1;
          gsap.fromTo(item, { opacity: 0, y: 12 }, { opacity: 1, y: 0, duration: 0.4 });
        } else {
          item.style.display = 'none';
        }
      });

      updateCount(visible);
    });
  });
}
