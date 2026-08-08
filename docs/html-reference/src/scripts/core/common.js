import { initLenis } from './lenis.js';
import { ScrollTrigger } from './gsap.js';
import { initHeader, initFooterYear } from '../components/header.js';
import { initReveal } from '../components/reveal.js';

export function initCommon() {
  initHeader();
  initFooterYear();
  initReveal();
  initLenis();

  window.requestAnimationFrame(() => ScrollTrigger.refresh());
}
