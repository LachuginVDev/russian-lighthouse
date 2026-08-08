import { gsap, prefersReducedMotion } from '../core/gsap.js';

export function initHeroEntrance() {
  const eyebrow = document.querySelector('.hero__eyebrow');
  const subtitle = document.querySelector('.hero__subtitle');
  const actions = document.querySelector('.hero__actions');
  const visual = document.querySelector('.hero__visual');

  if (prefersReducedMotion) {
    document.querySelector('[data-hero-beacon]')?.classList.add('is-lit');
    return;
  }

  if (eyebrow && subtitle && actions) {
    gsap.set([eyebrow, subtitle, actions], { opacity: 0, y: 24 });

    gsap
      .timeline({ delay: 0.1 })
      .to(eyebrow, { opacity: 1, y: 0, duration: 0.7 })
      .to(subtitle, { opacity: 1, y: 0, duration: 0.8 }, 1.1)
      .to(actions, { opacity: 1, y: 0, duration: 0.8 }, 1.35);
  }

  if (visual) {
    gsap.set(visual, { opacity: 1 });
    initBeaconDraw();
  }
}

function initBeaconDraw() {
  const beacon = document.querySelector('[data-hero-beacon]');
  const strokes = Array.from(document.querySelectorAll('.hero__beacon-stroke[data-draw]'));
  const origin = document.querySelector('.hero__beacon-origin');
  const glow = document.querySelector('[data-hero-beacon-glow]');

  if (!beacon || !strokes.length) return;

  strokes.sort(
    (a, b) => Number(a.dataset.drawOrder || 0) - Number(b.dataset.drawOrder || 0),
  );

  const prepared = strokes.map((el) => {
    const length =
      typeof el.getTotalLength === 'function'
        ? el.getTotalLength()
        : 120;

    gsap.set(el, {
      strokeDasharray: length,
      strokeDashoffset: length,
    });

    return { el, length };
  });

  gsap.set(origin, { opacity: 0, scale: 0.4, transformOrigin: '50% 50%' });
  gsap.set(glow, { opacity: 0 });

  const tl = gsap.timeline({ delay: 0.25 });

  prepared.forEach(({ el, length }, index) => {
    tl.to(
      el,
      {
        strokeDashoffset: 0,
        duration: Math.min(0.9, 0.32 + length / 380),
        ease: 'power2.inOut',
      },
      index === 0 ? 0 : '-=0.22',
    );
  });

  tl.to(origin, { opacity: 1, scale: 1, duration: 0.45, ease: 'power2.out' }, '-=0.2')
    .to(
      glow,
      {
        opacity: 1,
        duration: 0.7,
        ease: 'power1.out',
        onComplete: () => beacon.classList.add('is-lit'),
      },
      '-=0.25',
    );
}

export function initHeroParallax() {
  const media = document.querySelector('[data-hero-parallax]');
  const img = document.querySelector('[data-hero-img]');

  if (!media || !img || prefersReducedMotion) return;

  gsap.to(img, {
    yPercent: 16,
    ease: 'none',
    scrollTrigger: {
      trigger: media,
      start: 'top top',
      end: 'bottom top',
      scrub: true,
    },
  });
}
