import { prefersReducedMotion } from '../core/gsap.js';

/**
 * Частицы вокруг источника (маяк / лого), а не по всему экрану.
 * На каждом [data-particles] можно задать data-particles-origin="селектор"
 * или data-particles-origin="self" — центр самого canvas.
 */
export function initParticles() {
  if (prefersReducedMotion) return;

  document.querySelectorAll('[data-particles]').forEach((canvas) => {
    mountParticles(canvas);
  });
}

function mountParticles(canvas) {
  if (!(canvas instanceof HTMLCanvasElement)) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  const count = Number(canvas.dataset.particlesCount) || 36;
  const spread = Number(canvas.dataset.particlesSpread) || 90;
  let particles = [];
  let width = 0;
  let height = 0;
  let originX = 0;
  let originY = 0;
  let rafId = 0;

  const resolveOrigin = () => {
    const mode = canvas.dataset.particlesOrigin || 'self';
    const canvasRect = canvas.getBoundingClientRect();

    if (mode === 'self') {
      originX = width / 2;
      originY = height / 2;
      return;
    }

    const el = document.querySelector(mode);
    if (!el) {
      originX = width * 0.72;
      originY = height * 0.42;
      return;
    }

    const r = el.getBoundingClientRect();
    originX = r.left + r.width / 2 - canvasRect.left;
    originY = r.top + r.height * 0.18 - canvasRect.top;
  };

  const resize = () => {
    width = canvas.clientWidth;
    height = canvas.clientHeight;
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    canvas.width = Math.max(1, Math.floor(width * dpr));
    canvas.height = Math.max(1, Math.floor(height * dpr));
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    resolveOrigin();
  };

  const createParticle = (fromTop = false) => {
    const angle = -Math.PI / 2 + (Math.random() - 0.5) * 1.1;
    const dist = Math.random() * spread * 0.35;
    return {
      x: originX + Math.cos(angle) * dist + (Math.random() - 0.5) * 12,
      y: fromTop ? originY + spread * 0.2 : originY + Math.sin(angle) * dist * 0.4,
      r: 0.5 + Math.random() * 1.8,
      vx: (Math.random() - 0.5) * 0.35,
      vy: -(0.25 + Math.random() * 0.55),
      alpha: 0.2 + Math.random() * 0.45,
      life: 0.55 + Math.random() * 0.45,
      age: Math.random(),
    };
  };

  const resetParticle = (p) => {
    const next = createParticle(true);
    Object.assign(p, next, { age: 0 });
  };

  const init = () => {
    resize();
    particles = Array.from({ length: count }, () => createParticle());
  };

  const draw = () => {
    ctx.clearRect(0, 0, width, height);

    // мягкое свечение у источника
    const glow = ctx.createRadialGradient(originX, originY, 0, originX, originY, spread * 0.7);
    glow.addColorStop(0, 'rgba(230, 198, 124, 0.16)');
    glow.addColorStop(0.45, 'rgba(230, 198, 124, 0.05)');
    glow.addColorStop(1, 'rgba(230, 198, 124, 0)');
    ctx.fillStyle = glow;
    ctx.beginPath();
    ctx.arc(originX, originY, spread * 0.7, 0, Math.PI * 2);
    ctx.fill();

    particles.forEach((p) => {
      p.age += 0.004;
      p.x += p.vx;
      p.y += p.vy;
      p.vx += (Math.random() - 0.5) * 0.02;

      const fade = Math.max(0, 1 - p.age / p.life);
      const dx = p.x - originX;
      const dy = p.y - originY;
      const tooFar = Math.hypot(dx, dy) > spread;

      if (fade <= 0 || tooFar || p.y < originY - spread) {
        resetParticle(p);
        return;
      }

      ctx.beginPath();
      ctx.fillStyle = `rgba(230, 198, 124, ${p.alpha * fade})`;
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fill();
    });

    rafId = requestAnimationFrame(draw);
  };

  init();
  draw();

  const onResize = () => {
    cancelAnimationFrame(rafId);
    init();
    draw();
  };

  window.addEventListener('resize', onResize);
}
