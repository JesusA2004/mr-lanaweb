export type KickerPart = {
    text: string
    highlight?: boolean
}

export type HomeBanner = {
    id: string
    desktopSrc: string
    mobileSrc: string
    alt: string
    // CTA (solo botón)
    ctaLabel?: string
    ctaHref?: string
    // Texto blanco arriba del botón (en partes para resaltar palabras)
    kickerParts?: KickerPart[]
    // Overlay PNG encima (solo banner-1)
    overlaySrc?: string
    // Separación extra
    className?: string
}

export const homeBanners: HomeBanner[] = [
    {
        id: 'banner-1',
        desktopSrc: '/img/banner/banner-1.webp',
        mobileSrc: '/img/banner/banner-1.webp',
        alt: 'Obtén un crédito diario o semanal',
        ctaLabel: 'Obténlo Ahora',
        ctaHref: '#solicitar',
        overlaySrc: '/img/banner/banner-1-degree-text.png',
        kickerParts: [
            { text: 'Obtén un crédito ' },
            { text: 'DIARIO', highlight: true },
            { text: ' o ' },
            { text: 'Semanal', highlight: true },
            { text: ' para tu negocio' },
        ],
    },
    {
        id: 'banner-2',
        desktopSrc: '/img/banner/banner-2.jpg',
        mobileSrc: '/img/banner/banner-2.jpg',
        alt: 'Crédito para lo que deseas',
        ctaLabel: 'Obténlo Ahora',
        ctaHref: '#solicitar',
        kickerParts: [
            { text: 'Crédito para aquello que más deseas...' },
            { text: ' o quieres', highlight: true },
        ],
    },
    {
        id: 'banner-3',
        desktopSrc: '/img/banner/banner-3.jpg',
        mobileSrc: '/img/banner/banner-3.jpg',
        alt: 'Crédito Comadres',
        ctaLabel: 'Solicita ahora',
        ctaHref: '#solicitar',
        kickerParts: [
            { text: 'Crédito ' },
            { text: 'Comadres', highlight: true },
            { text: ': rápido, claro y sin vueltas' },
        ],
    },
]
