import { formatTime } from '../utils/formatNumber.js';

export function initPlayer() {
  const root = document.querySelector('[data-player]');
  if (!root) return;

  const audio = new Audio();
  audio.preload = 'metadata';

  const playBtn = root.querySelector('[data-player-play]');
  const playIcon = root.querySelector('[data-player-play-icon] use');
  const prevBtn = root.querySelector('[data-player-prev]');
  const nextBtn = root.querySelector('[data-player-next]');
  const cover = root.querySelector('[data-player-cover]');
  const titleEl = root.querySelector('[data-player-title]');
  const artistEl = root.querySelector('[data-player-artist]');
  const currentEl = root.querySelector('[data-player-current]');
  const durationEl = root.querySelector('[data-player-duration]');
  const seekFill = root.querySelector('[data-player-seek-fill]');
  const seekInput = root.querySelector('[data-player-seek-input]');
  const waveEl = root.querySelector('[data-player-wave]');
  const tracks = Array.from(root.querySelectorAll('[data-track]'));

  let currentIndex = 0;
  let waveRaf = null;

  const waveBars = Array.from({ length: 24 }, () => {
    const bar = document.createElement('span');
    bar.className = 'player__wave-bar';
    waveEl?.appendChild(bar);
    return bar;
  });

  const setActiveTrack = (index) => {
    tracks.forEach((track, i) => track.classList.toggle('is-active', i === index));
  };

  const startWave = () => {
    stopWave();
    const animate = () => {
      waveBars.forEach((bar) => {
        bar.style.height = `${12 + Math.random() * 88}%`;
      });
      waveRaf = requestAnimationFrame(animate);
    };
    animate();
  };

  const stopWave = () => {
    if (waveRaf) cancelAnimationFrame(waveRaf);
    waveRaf = null;
    waveBars.forEach((bar) => {
      bar.style.height = '20%';
    });
  };

  const play = () => {
    audio.play().catch(() => {});
    playIcon?.setAttribute('href', '#icon-pause');
    playBtn?.setAttribute('aria-label', 'Пауза');
    cover?.classList.add('is-playing');
    startWave();
  };

  const pause = () => {
    audio.pause();
    playIcon?.setAttribute('href', '#icon-play');
    playBtn?.setAttribute('aria-label', 'Воспроизвести');
    cover?.classList.remove('is-playing');
    stopWave();
  };

  const togglePlay = () => {
    if (audio.paused) play();
    else pause();
  };

  const loadTrack = (index, { autoplay = false } = {}) => {
    const track = tracks[index];
    if (!track) return;

    currentIndex = index;
    setActiveTrack(index);
    if (titleEl) titleEl.textContent = track.dataset.title || '';
    if (artistEl) artistEl.textContent = track.dataset.artist || '';
    if (durationEl) durationEl.textContent = track.dataset.duration || '0:00';
    if (seekFill) seekFill.style.width = '0%';
    if (seekInput) seekInput.value = '0';
    if (currentEl) currentEl.textContent = '0:00';
    audio.src = track.dataset.src || '';

    if (autoplay) play();
    else pause();
  };

  const goTo = (delta) => {
    const wasPlaying = !audio.paused;
    const nextIndex = (currentIndex + delta + tracks.length) % tracks.length;
    loadTrack(nextIndex, { autoplay: wasPlaying });
  };

  playBtn?.addEventListener('click', togglePlay);
  prevBtn?.addEventListener('click', () => goTo(-1));
  nextBtn?.addEventListener('click', () => goTo(1));

  tracks.forEach((track, index) => {
    track.addEventListener('click', () => loadTrack(index, { autoplay: true }));
  });

  audio.addEventListener('timeupdate', () => {
    if (!audio.duration || !seekFill || !seekInput || !currentEl) return;
    const percent = (audio.currentTime / audio.duration) * 100;
    seekFill.style.width = `${percent}%`;
    seekInput.value = String(percent);
    currentEl.textContent = formatTime(audio.currentTime);
  });

  audio.addEventListener('loadedmetadata', () => {
    if (durationEl) durationEl.textContent = formatTime(audio.duration);
  });

  audio.addEventListener('ended', () => goTo(1));

  seekInput?.addEventListener('input', () => {
    if (!audio.duration) return;
    audio.currentTime = (Number(seekInput.value) / 100) * audio.duration;
  });

  loadTrack(0);
}
