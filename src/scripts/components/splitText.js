import Splitting from 'splitting';
import 'splitting/dist/splitting.css';
import { gsap, prefersReducedMotion } from '../core/gsap.js';

export function initSplitText() {
  const results = Splitting({ target: '[data-split-text]', by: 'chars' });

  if (prefersReducedMotion) return;

  results.forEach(({ chars }) => {
    gsap.set(chars, { opacity: 0, yPercent: 60, rotateX: -35, transformOrigin: '50% 100%' });
    gsap.to(chars, {
      opacity: 1,
      yPercent: 0,
      rotateX: 0,
      duration: 1,
      ease: 'power4.out',
      stagger: 0.032,
      delay: 0.25,
    });
  });
}
