export function initToc() {
  const toc = document.querySelector('[data-toc]');
  if (!toc) return;

  const links = Array.from(toc.querySelectorAll('[data-toc-link]'));
  if (!links.length) return;

  const targets = links
    .map((link) => document.querySelector(link.getAttribute('href')))
    .filter(Boolean);

  const setActive = (id) => {
    links.forEach((link) => {
      link.classList.toggle('is-active', link.getAttribute('href') === `#${id}`);
    });
  };

  const observer = new IntersectionObserver(
    (entries) => {
      const visible = entries.find((entry) => entry.isIntersecting);
      if (visible) setActive(visible.target.id);
    },
    { rootMargin: '-15% 0px -70% 0px' }
  );

  targets.forEach((target) => observer.observe(target));
}
