import { initCommon } from '../core/common.js';

function init() {
  initCommon();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
