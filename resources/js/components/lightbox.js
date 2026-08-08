export function initLightbox(items) {
  if (!items?.length) return;

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
