export function initVideoModal() {
  const triggers = Array.from(document.querySelectorAll('[data-video-trigger]'));
  if (!triggers.length) return;

  let modal = document.querySelector('[data-video-modal]');

  if (!modal) {
    modal = document.createElement('div');
    modal.className = 'video-modal';
    modal.setAttribute('data-video-modal', '');
    modal.setAttribute('role', 'dialog');
    modal.setAttribute('aria-modal', 'true');
    modal.setAttribute('aria-label', 'Просмотр видео');
    modal.innerHTML = `
      <span class="video-modal__title" data-video-modal-title></span>
      <button class="video-modal__close" type="button" aria-label="Закрыть видео">
        <svg aria-hidden="true"><use href="#icon-close" /></svg>
      </button>
      <div class="video-modal__frame" data-video-modal-frame></div>
    `;
    document.body.appendChild(modal);
  }

  const frame = modal.querySelector('[data-video-modal-frame]');
  const titleEl = modal.querySelector('[data-video-modal-title]');
  const closeBtn = modal.querySelector('.video-modal__close');

  const close = () => {
    modal.classList.remove('is-open');
    frame.innerHTML = '';
    document.body.style.overflow = '';
  };

  const open = (trigger) => {
    const title = trigger.dataset.videoTitle || '';
    const embedUrl = trigger.dataset.videoEmbed;
    if (titleEl) titleEl.textContent = title;

    frame.innerHTML = embedUrl
      ? `<iframe class="video-modal__iframe" src="${embedUrl}" title="${title}" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen loading="lazy"></iframe>`
      : `<div class="video-modal__placeholder">Видеозапись появится здесь после публикации</div>`;

    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  };

  triggers.forEach((trigger) => {
    trigger.addEventListener('click', () => open(trigger));
  });

  closeBtn?.addEventListener('click', close);
  modal.addEventListener('click', (event) => {
    if (event.target === modal) close();
  });
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') close();
  });
}
