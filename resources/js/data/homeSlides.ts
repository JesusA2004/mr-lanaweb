export type SlideTone = 'white' | 'accent' | 'muted' | 'black'

export type SlideTextPart = {
    text: string
    tone: SlideTone
    bold?: boolean
    breakAfter?: boolean
}

export type SlideOverlay = {
    titleParts: SlideTextPart[]
    subtitleParts: SlideTextPart[]
    ctaLabel: string
    ctaHref: string
}

export type Slide = {
    id: string
    desktopSrc: string
    mobileSrc: string
    alt: string
    overlay: SlideOverlay
}

export const homeSlides: Slide[] = [
    {
        id: 's1',
        desktopSrc: '/img/home/Slider-1.jfif',
        mobileSrc: '/img/home/Slider-mobile1.jfif',
        alt: 'Mr Lana - Negocio',
        overlay: {
            titleParts: [
                { text: 'El ', tone: 'white', bold: true },
                { text: 'impulso', tone: 'black', bold: true },
                { text: ' que necesitas', tone: 'white', bold: true, breakAfter: true },
            ],
            subtitleParts: [
                { text: 'Obtén un crédito para tu ', tone: 'muted', bold: true },
                { text: 'negocio', tone: 'muted', bold: true },
                { text: ' fácil y rápido', tone: 'black', bold: true },
            ],
            ctaLabel: 'Solicitar Ahora',
            ctaHref: '/impulsa-tu-negocio',
        },
    },
    {
        id: 's2',
        desktopSrc: '/img/home/Slider-2.jfif',
        mobileSrc: '/img/home/Slider-mobile2.jfif',
        alt: 'Mr Lana - Vacaciones',
        overlay: {
            titleParts: [
                { text: '¿Qué tal unas ', tone: 'white', bold: true },
                { text: 'vacaciones', tone: 'black', bold: true},
                { text: '?', tone: 'white', bold: true },
            ],
            subtitleParts: [
                { text: 'O ese celular que quieres esto y más… ', tone: 'muted', bold: true},
                { text: 'fácil y rápido', tone: 'black', bold: true },
            ],
            ctaLabel: 'Solicitar Ahora',
            ctaHref: '/impulsat',
        },
    },
    {
        id: 's3',
        desktopSrc: '/img/home/Slider-3.jfif',
        mobileSrc: '/img/home/Slider-mobile3.jfif',
        alt: 'Mr Lana - Comadres',
        overlay: {
            titleParts: [
                { text: 'Crédito ', tone: 'white', bold: true },
                { text: 'Comadres', tone: 'black', bold: true, breakAfter: true },
            ],
            subtitleParts: [
                { text: 'Más que amigas… ', tone: 'muted', bold: true },
                { text: 'Comadres financieras', tone: 'white', bold: true },
            ],
            ctaLabel: 'Solicitar Ahora',
            ctaHref: '/impulsat',
        },
    },
]
