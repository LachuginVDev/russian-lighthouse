import { gsap, prefersReducedMotion } from '../core/gsap.js';

export function initCounters() {
  document.querySelectorAll('[data-count]').forEach((el) => {
    const target = Number(el.dataset.count);

    if (prefersReducedMotion) {
      el.textContent = String(target);
      return;
    }

    gsap.fromTo(
      el,
      { textContent: 0 },
      {
        textContent: target,
        duration: 1.6,
        ease: 'power2.out',
        snap: { textContent: 1 },
        scrollTrigger: {
          trigger: el,
          start: 'top 90%',
          once: true,
        },
      }
    );
  });
}
