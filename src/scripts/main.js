import '../styles/main.scss';

import { initLenis } from './core/lenis.js';
import { initHeader, initFooterYear } from './components/header.js';
import { initHeroEntrance, initHeroParallax } from './components/hero.js';
import { initParticles } from './components/particles.js';
import { initSplitText } from './components/splitText.js';
import { initReveal } from './components/reveal.js';
import { initCounters } from './components/counter.js';
import { initPlayer } from './components/player.js';
import { initVideoSlider } from './components/videoSlider.js';
import { initPhotoGallery } from './components/photoGallery.js';
import { initFundraisingProgress } from './components/progress.js';
import { initCopyRequisites } from './components/copyRequisites.js';
import { initContactForm } from './components/contactForm.js';
import { ScrollTrigger } from './core/gsap.js';

function init() {
  initHeader();
  initFooterYear();
  initSplitText();
  initHeroEntrance();
  initHeroParallax();
  initParticles();
  initReveal();
  initCounters();
  initPlayer();
  initVideoSlider();
  initPhotoGallery();
  initFundraisingProgress();
  initCopyRequisites();
  initContactForm();
  initLenis();

  window.requestAnimationFrame(() => ScrollTrigger.refresh());
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
