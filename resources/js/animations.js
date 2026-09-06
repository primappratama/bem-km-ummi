import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// ─── Respect prefers-reduced-motion ───────────────────────────────────────────
const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

document.addEventListener('DOMContentLoaded', () => {

    // ── 1. Hero entrance ────────────────────────────────────────────────────────
    const heroTL = gsap.timeline({
        defaults: { ease: 'power3.out', duration: 0.65 },
    });

    heroTL
        .from('.js-hero-eyebrow', { y: 20, opacity: 0, duration: 0.5 })
        .from('.js-hero-title',   { y: 32, opacity: 0 }, '-=0.3')
        .from('.js-hero-desc',    { y: 20, opacity: 0 }, '-=0.4')
        .from('.js-hero-cta',     { y: 16, opacity: 0 }, '-=0.35')
        .from('.js-hero-stats > *', { y: 20, opacity: 0, stagger: 0.08 }, '-=0.4')
        .from('.js-hero-dots span', { opacity: 0, scale: 0, stagger: 0.04 }, '-=0.5');

    // ── 2. Mouse parallax on hero orbs ──────────────────────────────────────────
    if (!reduced) {
        const hero = document.querySelector('section');
        hero?.addEventListener('mousemove', (e) => {
            const rect = hero.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width  - 0.5) * 24;
            const y = ((e.clientY - rect.top)  / rect.height - 0.5) * 16;

            gsap.to('.js-orb-1', { x: x * 1.8, y: y * 1.4, duration: 2.2, ease: 'power2.out', overwrite: 'auto' });
            gsap.to('.js-orb-2', { x: -x,       y: -y,      duration: 2.8, ease: 'power2.out', overwrite: 'auto' });
            gsap.to('.js-orb-3', { x: x * 0.8,  y: y * 1.2, duration: 3.0, ease: 'power2.out', overwrite: 'auto' });
        });
    }

    // ── 3. Scroll reveals — individual .js-reveal ───────────────────────────────
    document.querySelectorAll('.js-reveal').forEach((el) => {
        if (reduced) return;
        gsap.fromTo(el,
            { y: 28, opacity: 0 },
            {
                y: 0, opacity: 1,
                duration: 0.65,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 84%',
                    once: true,
                },
            }
        );
    });

    // ── 4. Scroll reveals — staggered .js-reveal-group > .js-reveal ─────────────
    document.querySelectorAll('.js-reveal-group').forEach((group) => {
        if (reduced) return;
        const items = group.querySelectorAll('.js-reveal');
        if (!items.length) return;

        gsap.fromTo(items,
            { y: 28, opacity: 0 },
            {
                y: 0, opacity: 1,
                duration: 0.55,
                ease: 'power2.out',
                stagger: 0.07,
                scrollTrigger: {
                    trigger: group,
                    start: 'top 82%',
                    once: true,
                },
            }
        );
    });

    // ── 5. Navbar scroll effect — increase opacity on scroll ────────────────────
    const header = document.getElementById('site-header');
    if (header) {
        const pill = header.querySelector('.glass-nav');
        ScrollTrigger.create({
            start: 'top -80',
            onUpdate: (self) => {
                const progress = Math.min(self.scroll() / 200, 1);
                if (pill) {
                    pill.style.boxShadow = `0 ${4 + progress * 8}px ${24 + progress * 16}px rgba(16,42,82,${0.06 + progress * 0.08})`;
                }
            },
        });
    }

    // ── 6. Gradient text shimmer on hero ────────────────────────────────────────
    const gradText = document.querySelector('.js-gradient-text');
    if (gradText && !reduced) {
        gsap.fromTo(gradText,
            { backgroundPosition: '0% 50%' },
            {
                backgroundPosition: '100% 50%',
                duration: 3,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut',
            }
        );
        gradText.style.backgroundSize = '200% 100%';
    }

});
