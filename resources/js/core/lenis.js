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

  const isHomePath = (pathname) => pathname === '/' || pathname.endsWith('/index.html');

  document.querySelectorAll('a[href*="#"]').forEach((link) => {
    link.addEventListener('click', (event) => {
      const url = new URL(link.href, window.location.href);
      if (!url.hash) return;

      const isSamePage = url.pathname === window.location.pathname || (isHomePath(url.pathname) && isHomePath(window.location.pathname));
      if (!isSamePage) return;

      const target = document.querySelector(url.hash);
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
