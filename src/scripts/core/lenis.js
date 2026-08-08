import Lenis from 'lenis';
import { gsap, ScrollTrigger, prefersReducedMotion } from './gsap.js';

let lenis = null;

export function initLenis() {
  if (prefersReducedMotion) return null;

  lenis = new Lenis({
    duration: 1.1,
    smoothWheel: true,
    wheelMultiplier: 1,
    touchMultiplier: 1.2,
  });

  lenis.on('scroll', ScrollTrigger.update);

  gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
  });
  gsap.ticker.lagSmoothing(0);

  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener('click', (event) => {
      const targetId = link.getAttribute('href');
      if (!targetId || targetId === '#') return;
      const target = document.querySelector(targetId);
      if (!target) return;
      event.preventDefault();
      lenis.scrollTo(target, { offset: -80 });
    });
  });

  return lenis;
}

export function getLenis() {
  return lenis;
}
