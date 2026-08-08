export function initHeader() {
  const header = document.querySelector('[data-header]');
  const toggle = document.querySelector('[data-nav-toggle]');
  const toggleIcon = document.querySelector('[data-nav-toggle-icon] use');
  const mobileNav = document.querySelector('[data-mobile-nav]');

  if (header) {
    const updateHeaderState = () => {
      header.classList.toggle('is-scrolled', window.scrollY > 24);
    };
    updateHeaderState();
    window.addEventListener('scroll', updateHeaderState, { passive: true });
  }

  if (!toggle || !mobileNav) return;

  const setOpen = (isOpen) => {
    mobileNav.classList.toggle('is-open', isOpen);
    toggle.setAttribute('aria-expanded', String(isOpen));
    toggle.setAttribute('aria-label', isOpen ? 'Закрыть меню' : 'Открыть меню');
    toggleIcon?.setAttribute('href', isOpen ? '#icon-close' : '#icon-burger');
    document.body.style.overflow = isOpen ? 'hidden' : '';
  };

  toggle.addEventListener('click', () => {
    setOpen(!mobileNav.classList.contains('is-open'));
  });

  mobileNav.querySelectorAll('[data-nav-link]').forEach((link) => {
    link.addEventListener('click', () => setOpen(false));
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') setOpen(false);
  });
}

export function initFooterYear() {
  const el = document.querySelector('[data-current-year]');
  if (el) el.textContent = String(new Date().getFullYear());
}
