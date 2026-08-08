import { gsap } from '../core/gsap.js';

export function initPhotoGallery() {
  const gallery = document.querySelector('[data-gallery]');
  const filters = document.querySelectorAll('[data-gallery-filters] [data-filter]');
  if (!gallery) return;

  const items = Array.from(gallery.querySelectorAll('[data-category]'));

  filters.forEach((filter) => {
    filter.addEventListener('click', () => {
      filters.forEach((f) => {
        f.classList.remove('is-active');
        f.setAttribute('aria-selected', 'false');
      });
      filter.classList.add('is-active');
      filter.setAttribute('aria-selected', 'true');

      const category = filter.dataset.filter;

      items.forEach((item) => {
        const matches = category === 'all' || item.dataset.category === category;
        if (matches) {
          item.style.display = '';
          gsap.fromTo(item, { opacity: 0, scale: 0.94 }, { opacity: 1, scale: 1, duration: 0.4 });
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

  initLightbox(items);
}

function initLightbox(items) {
  let overlay = document.querySelector('[data-lightbox]');

  if (!overlay) {
    overlay = document.createElement('div');
    overlay.setAttribute('data-lightbox', '');
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');
    overlay.setAttribute('aria-label', 'Просмотр фотографии');
    overlay.className = 'lightbox';
    overlay.innerHTML = `
      <button class="lightbox__close" type="button" aria-label="Закрыть">
        <svg aria-hidden="true"><use href="#icon-close" /></svg>
      </button>
      <div class="lightbox__frame"></div>
    `;
    document.body.appendChild(overlay);
  }

  const frame = overlay.querySelector('.lightbox__frame');
  const closeBtn = overlay.querySelector('.lightbox__close');

  const close = () => {
    overlay.classList.remove('is-open');
    document.body.style.overflow = '';
  };

  const open = (source) => {
    frame.className = 'lightbox__frame';
    frame.style.background = getComputedStyle(source).background;
    overlay.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  };

  items.forEach((item) => {
    item.addEventListener('click', () => open(item));
  });

  closeBtn.addEventListener('click', close);
  overlay.addEventListener('click', (event) => {
    if (event.target === overlay) close();
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') close();
  });
}
