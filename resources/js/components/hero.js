import { gsap, prefersReducedMotion } from '../core/gsap.js';

export function initHeroEntrance() {
  const eyebrow = document.querySelector('.hero__eyebrow');
  const subtitle = document.querySelector('.hero__subtitle');
  const actions = document.querySelector('.hero__actions');

  if (prefersReducedMotion || !eyebrow || !subtitle || !actions) return;

  gsap.set([eyebrow, subtitle, actions], { opacity: 0, y: 24 });

  gsap
    .timeline({ delay: 0.1 })
    .to(eyebrow, { opacity: 1, y: 0, duration: 0.7 })
    .to(subtitle, { opacity: 1, y: 0, duration: 0.8 }, 1.1)
    .to(actions, { opacity: 1, y: 0, duration: 0.8 }, 1.35);
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
