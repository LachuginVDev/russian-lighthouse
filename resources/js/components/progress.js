import { gsap, ScrollTrigger, prefersReducedMotion } from '../core/gsap.js';
import { formatNumber } from '../utils/formatNumber.js';

export function initFundraisingProgress() {
  const block = document.querySelector('[data-progress]');
  if (!block) return;

  const goal = Number(block.dataset.goal) || 0;
  const current = Number(block.dataset.current) || 0;
  const percent = goal ? Math.min(100, (current / goal) * 100) : 0;

  const fill = block.querySelector('[data-progress-fill]');
  const sumEl = block.querySelector('[data-progress-current]');
  const percentEl = block.querySelector('[data-progress-percent]');

  const run = () => {
    if (fill) fill.style.width = `${percent}%`;
    if (percentEl) percentEl.textContent = `${Math.round(percent)}%`;

    if (!sumEl) return;

    if (prefersReducedMotion) {
      sumEl.textContent = formatNumber(current);
      return;
    }

    gsap.fromTo(
      sumEl,
      { textContent: 0 },
      {
        textContent: current,
        duration: 1.8,
        ease: 'power2.out',
        snap: { textContent: 1 },
        onUpdate() {
          sumEl.textContent = formatNumber(Number(sumEl.textContent));
        },
      }
    );
  };

  if (prefersReducedMotion) {
    run();
    return;
  }

  gsap.set(fill, { width: '0%' });

  ScrollTrigger.create({
    trigger: block,
    start: 'top 85%',
    once: true,
    onEnter: run,
  });
}
