import { prefersReducedMotion } from '../core/gsap.js';

const PARTICLE_COUNT = 46;

export function initParticles() {
  const canvas = document.querySelector('[data-particles]');
  if (!canvas || prefersReducedMotion) return;

  const ctx = canvas.getContext('2d');
  let particles = [];
  let width = 0;
  let height = 0;
  let rafId = null;

  const resize = () => {
    width = canvas.clientWidth;
    height = canvas.clientHeight;
    canvas.width = width * devicePixelRatio;
    canvas.height = height * devicePixelRatio;
    ctx.scale(devicePixelRatio, devicePixelRatio);
  };

  const createParticle = () => ({
    x: Math.random() * width,
    y: Math.random() * height,
    r: 0.6 + Math.random() * 1.6,
    speed: 0.15 + Math.random() * 0.35,
    drift: (Math.random() - 0.5) * 0.2,
    alpha: 0.15 + Math.random() * 0.35,
  });

  const init = () => {
    resize();
    particles = Array.from({ length: PARTICLE_COUNT }, createParticle);
  };

  const draw = () => {
    ctx.clearRect(0, 0, width, height);
    particles.forEach((p) => {
      p.y -= p.speed;
      p.x += p.drift;
      if (p.y < -4) {
        p.y = height + 4;
        p.x = Math.random() * width;
      }
      ctx.beginPath();
      ctx.fillStyle = `rgba(230, 198, 124, ${p.alpha})`;
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fill();
    });
    rafId = requestAnimationFrame(draw);
  };

  init();
  draw();

  window.addEventListener('resize', () => {
    cancelAnimationFrame(rafId);
    init();
    draw();
  });
}
