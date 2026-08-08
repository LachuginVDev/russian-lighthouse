export function initCopyRequisites() {
  document.querySelectorAll('[data-copy]').forEach((button) => {
    button.addEventListener('click', async () => {
      const value = button.dataset.copy || '';

      try {
        await navigator.clipboard.writeText(value);
      } catch {
        const helper = document.createElement('textarea');
        helper.value = value;
        helper.style.position = 'fixed';
        helper.style.opacity = '0';
        document.body.appendChild(helper);
        helper.select();
        document.execCommand('copy');
        helper.remove();
      }

      const originalLabel = button.textContent.trim();
      button.classList.add('is-copied');
      button.innerHTML = '<svg aria-hidden="true"><use href="#icon-check" /></svg>Скопировано';

      window.setTimeout(() => {
        button.classList.remove('is-copied');
        button.innerHTML = `<svg aria-hidden="true"><use href="#icon-copy" /></svg>${originalLabel}`;
      }, 2000);
    });
  });
}
