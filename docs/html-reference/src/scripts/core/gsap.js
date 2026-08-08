import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

gsap.defaults({ ease: 'power3.out' });

export { gsap, ScrollTrigger, prefersReducedMotion };
