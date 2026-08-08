import { gsap, prefersReducedMotion } from '../core/gsap.js';

export function initHeroEntrance() {
  const eyebrow = document.querySelector('.hero__eyebrow');
  const subtitle = document.querySelector('.hero__subtitle');
  const actions = document.querySelector('.hero__actions');
  const glow = document.querySelector('[data-hero-glow]');

  if (prefersReducedMotion) {
    glow?.classList.add('is-lit');
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

  if (glow) {
    gsap.set(glow, { opacity: 0, scale: 0.85 });
    gsap.to(glow, {
      opacity: 1,
      scale: 1,
      duration: 1.4,
      delay: 0.35,
      ease: 'power2.out',
      onComplete: () => glow.classList.add('is-lit'),
    });
  }
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
