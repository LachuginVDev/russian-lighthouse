import { prefersReducedMotion } from '../core/gsap.js';

/**
 * Частицы на canvas [data-particles].
 * mode:
 *  - field — по всему блоку (hero)
 *  - emit  — выброс вверх от data-particles-origin
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

  const count = Number(canvas.dataset.particlesCount) || 48;
  const spread = Number(canvas.dataset.particlesSpread) || 140;
  const mode = canvas.dataset.particlesMode || 'field';
  const isField = mode === 'field';

  let particles = [];
  let width = 0;
  let height = 0;
  let originX = 0;
  let originY = 0;
  let rafId = 0;

  const resolveOrigin = () => {
    if (isField) return;

    const originMode = canvas.dataset.particlesOrigin || 'self';
    const canvasRect = canvas.getBoundingClientRect();

    if (originMode === 'self') {
      originX = width / 2;
      originY = height / 2;
      return;
    }

    const el = document.querySelector(originMode);
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

  const createFieldParticle = () => ({
    x: Math.random() * width,
    y: Math.random() * height,
    r: 0.5 + Math.random() * 1.7,
    vx: (Math.random() - 0.5) * 0.18,
    vy: -(0.12 + Math.random() * 0.32),
    alpha: 0.12 + Math.random() * 0.38,
  });

  const createEmitParticle = (recycle = false) => {
    const angle = -Math.PI / 2 + (Math.random() - 0.5) * 1.15;
    const dist = Math.random() * spread * 0.35;

    return {
      x: originX + Math.cos(angle) * dist + (Math.random() - 0.5) * 12,
      y: recycle ? originY + 4 : originY + Math.sin(angle) * dist * 0.35,
      r: 0.5 + Math.random() * 1.8,
      vx: (Math.random() - 0.5) * 0.35,
      vy: -(0.25 + Math.random() * 0.55),
      alpha: 0.2 + Math.random() * 0.45,
      life: 0.55 + Math.random() * 0.45,
      age: recycle ? 0 : Math.random(),
    };
  };

  const createParticle = (recycle = false) =>
    (isField ? createFieldParticle() : createEmitParticle(recycle));

  const init = () => {
    resize();
    particles = Array.from({ length: count }, () => createParticle(false));
  };

  const draw = () => {
    ctx.clearRect(0, 0, width, height);

    if (!isField) {
      const glow = ctx.createRadialGradient(originX, originY, 0, originX, originY, spread * 0.7);
      glow.addColorStop(0, 'rgba(230, 198, 124, 0.16)');
      glow.addColorStop(0.45, 'rgba(230, 198, 124, 0.05)');
      glow.addColorStop(1, 'rgba(230, 198, 124, 0)');
      ctx.fillStyle = glow;
      ctx.beginPath();
      ctx.arc(originX, originY, spread * 0.7, 0, Math.PI * 2);
      ctx.fill();
    }

    particles.forEach((p) => {
      if (isField) {
        p.x += p.vx;
        p.y += p.vy;

        if (p.y < -4) {
          p.y = height + 4;
          p.x = Math.random() * width;
        }
        if (p.x < -4) p.x = width + 4;
        if (p.x > width + 4) p.x = -4;

        ctx.beginPath();
        ctx.fillStyle = `rgba(230, 198, 124, ${p.alpha})`;
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fill();
        return;
      }

      p.age += 0.004;
      p.x += p.vx;
      p.y += p.vy;
      p.vx += (Math.random() - 0.5) * 0.02;

      const fade = Math.max(0, 1 - p.age / p.life);
      const tooFar = Math.hypot(p.x - originX, p.y - originY) > spread;

      if (fade <= 0 || tooFar || p.y < originY - spread) {
        Object.assign(p, createEmitParticle(true));
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

  window.addEventListener('resize', () => {
    cancelAnimationFrame(rafId);
    init();
    draw();
  });
}
