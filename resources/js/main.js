import { initCommon } from './core/common.js';
import { initHeroEntrance, initHeroParallax } from './components/hero.js';
import { initSplitText } from './components/splitText.js';
import { initCounters } from './components/counter.js';
import { initPlayer } from './components/player.js';
import { initVideoSlider } from './components/videoSlider.js';
import { initVideoModal } from './components/videoModal.js';
import { initPhotoGallery } from './components/photoGallery.js';
import { initFundraisingProgress } from './components/progress.js';
import { initCopyRequisites } from './components/copyRequisites.js';
import { initContactForm } from './components/contactForm.js';

function init() {
  initSplitText();
  initHeroEntrance();
  initHeroParallax();
  initCounters();
  initPlayer();
  initVideoSlider();
  initVideoModal();
  initPhotoGallery();
  initFundraisingProgress();
  initCopyRequisites();
  initContactForm();
  initCommon();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
