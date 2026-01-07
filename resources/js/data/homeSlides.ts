import type { Slide } from '@/components/home/HeroCarousel.vue'

export const homeSlides: Slide[] = [
  {
    id: 's1',
    desktopSrc: '/img/home/Slider-1.jpg',
    mobileSrc: '/img/home/Slider-1.jpg',
    alt: 'Mr Lana - Negocio',
    overlay: {
      titleParts: [
        { text: 'El ', tone: 'white', bold: true },
        { text: 'impulso', tone: 'accent', bold: true },
        { text: ' que necesitas', tone: 'white', bold: true, breakAfter: true },
      ],
      subtitleParts: [
        { text: 'Obtén un crédito para tu ', tone: 'muted', bold: true },
        { text: 'negocio', tone: 'white', bold: true },
        { text: ' fácil y rápido', tone: 'muted', bold: true },
      ],
      ctaLabel: 'Solicitar Ahora',
      ctaHref: '/impulsa-tu-negocio',
    },
  },
  {
    id: 's2',
    desktopSrc: '/img/home/Slider-2.jpg',
    mobileSrc: '/img/home/Slider-2.jpg',
    alt: 'Mr Lana - Vacaciones',
    overlay: {
      titleParts: [
        { text: '¿Qué tal unas ', tone: 'white', bold: true },
        { text: 'vacaciones?', tone: 'accent', bold: true, breakAfter: true },
      ],
      subtitleParts: [
        { text: 'O ese celular que quieres… ', tone: 'muted', bold: true },
        { text: 'fácil y rápido', tone: 'white', bold: true },
      ],
      ctaLabel: 'Solicitar Ahora',
      ctaHref: '/impulsat',
    },
  },
  {
    id: 's3',
    desktopSrc: '/img/home/Slider-3.jpg',
    mobileSrc: '/img/home/Slider-3.jpg',
    alt: 'Mr Lana - Comadres',
    overlay: {
      titleParts: [
        { text: '¿Qué tal unas ', tone: 'white', bold: true },
        { text: 'vacaciones?', tone: 'accent', bold: true, breakAfter: true },
      ],
      subtitleParts: [
        { text: 'O ese celular que quieres… ', tone: 'muted', bold: true },
        { text: 'fácil y rápido', tone: 'white', bold: true },
      ],
      ctaLabel: 'Solicitar Ahora',
      ctaHref: '/impulsat',
    },
  },
]
