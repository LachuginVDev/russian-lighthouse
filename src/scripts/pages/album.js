import '../../styles/main.scss';

import { initCommon } from '../core/common.js';
import { initPlayer } from '../components/player.js';

function init() {
  initPlayer();
  initCommon();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
