import { initLenis } from './lenis.js';
import { ScrollTrigger } from './gsap.js';
import { initHeader, initFooterYear } from '../components/header.js';
import { initReveal } from '../components/reveal.js';
import { initParticles } from '../components/particles.js';

export function initCommon() {
  initHeader();
  initFooterYear();
  initReveal();
  initParticles();
  initLenis();

  window.requestAnimationFrame(() => ScrollTrigger.refresh());
}
