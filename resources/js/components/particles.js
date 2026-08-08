import { prefersReducedMotion } from '../core/gsap.js';

/**
 * Частицы вокруг источника (маяк / лого).
 * data-particles-origin="self"|селектор
 * data-particles-mode="halo"|emit  — ореол вокруг / выброс вверх от фонаря
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
  const mode = canvas.dataset.particlesMode || 'emit';
  const isHalo = mode === 'halo';

  let particles = [];
  let width = 0;
  let height = 0;
  let originX = 0;
  let originY = 0;
  let rafId = 0;

  const resolveOrigin = () => {
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
    originY = r.top + r.height * (isHalo ? 0.5 : 0.18) - canvasRect.top;
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

  const createHaloParticle = () => {
    const angle = Math.random() * Math.PI * 2;
    // равномерно по диску вокруг лого
    const dist = (0.35 + Math.random() * 0.65) * spread;
    const orbitSpeed = (0.004 + Math.random() * 0.01) * (Math.random() < 0.5 ? -1 : 1);

    return {
      angle,
      dist,
      orbitSpeed,
      x: originX + Math.cos(angle) * dist,
      y: originY + Math.sin(angle) * dist,
      r: 0.7 + Math.random() * 2.1,
      vx: 0,
      vy: -0.05 - Math.random() * 0.12,
      alpha: 0.25 + Math.random() * 0.5,
      life: 1.2 + Math.random() * 1.4,
      age: Math.random() * 0.8,
    };
  };

  const createEmitParticle = (recycle = false) => {
    const angle = -Math.PI / 2 + (Math.random() - 0.5) * 1.15;
    const dist = Math.random() * spread * 0.35;

    return {
      angle: 0,
      dist: 0,
      orbitSpeed: 0,
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
    (isHalo ? createHaloParticle() : createEmitParticle(recycle));

  const resetParticle = (p) => {
    Object.assign(p, createParticle(true), isHalo ? {} : { age: 0 });
    if (isHalo) p.age = 0;
  };

  const init = () => {
    resize();
    particles = Array.from({ length: count }, () => createParticle(false));
  };

  const draw = () => {
    ctx.clearRect(0, 0, width, height);

    const glowR = isHalo ? spread * 1.05 : spread * 0.7;
    const glow = ctx.createRadialGradient(originX, originY, 0, originX, originY, glowR);
    glow.addColorStop(0, isHalo ? 'rgba(230, 198, 124, 0.22)' : 'rgba(230, 198, 124, 0.16)');
    glow.addColorStop(0.45, 'rgba(230, 198, 124, 0.06)');
    glow.addColorStop(1, 'rgba(230, 198, 124, 0)');
    ctx.fillStyle = glow;
    ctx.beginPath();
    ctx.arc(originX, originY, glowR, 0, Math.PI * 2);
    ctx.fill();

    particles.forEach((p) => {
      p.age += isHalo ? 0.006 : 0.004;

      if (isHalo) {
        p.angle += p.orbitSpeed;
        // лёгкое «дыхание» радиуса
        const breathe = 1 + Math.sin(p.age * 3 + p.dist) * 0.04;
        p.x = originX + Math.cos(p.angle) * p.dist * breathe;
        p.y = originY + Math.sin(p.angle) * p.dist * breathe + p.vy * 8;
      } else {
        p.x += p.vx;
        p.y += p.vy;
        p.vx += (Math.random() - 0.5) * 0.02;
      }

      const fade = Math.max(0, 1 - p.age / p.life);
      const dx = p.x - originX;
      const dy = p.y - originY;
      const tooFar = Math.hypot(dx, dy) > spread * (isHalo ? 1.25 : 1);

      if (fade <= 0 || tooFar || (!isHalo && p.y < originY - spread)) {
        resetParticle(p);
        return;
      }

      // у ореола мягче пульсация прозрачности по кругу
      const twinkle = isHalo ? 0.65 + 0.35 * Math.sin(p.age * 5 + p.angle * 3) : 1;

      ctx.beginPath();
      ctx.fillStyle = `rgba(230, 198, 124, ${p.alpha * fade * twinkle})`;
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
