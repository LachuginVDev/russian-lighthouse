import { gsap, ScrollTrigger, prefersReducedMotion } from '../core/gsap.js';

const GROUP_SELECTORS = ['.grid', '.photo-gallery', '.requisites-grid', '.events-list', '.player__list'];

export function initReveal() {
  if (prefersReducedMotion) return;

  const groupedEls = new Set();

  GROUP_SELECTORS.forEach((selector) => {
    document.querySelectorAll(selector).forEach((group) => {
      const items = Array.from(group.children);
      if (!items.length) return;

      items.forEach((el) => groupedEls.add(el));
      gsap.set(items, { opacity: 0, y: 32 });

      ScrollTrigger.batch(items, {
        start: 'top 88%',
        once: true,
        onEnter: (batch) =>
          gsap.to(batch, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            stagger: 0.12,
          }),
      });
    });
  });

  document.querySelectorAll('[data-reveal]').forEach((el) => {
    if (groupedEls.has(el) || el.closest('.hero')) return;

    gsap.from(el, {
      opacity: 0,
      y: 28,
      duration: 0.9,
      scrollTrigger: {
        trigger: el,
        start: 'top 90%',
        once: true,
      },
    });
  });
}
