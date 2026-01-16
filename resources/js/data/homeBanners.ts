export type KickerPart = {
    text: string
    highlight?: boolean
}

export type HomeBanner = {
    id: string
    desktopSrc: string
    mobileSrc: string
    alt: string
    ctaLabel?: string
    ctaHref?: string
    kickerParts?: KickerPart[]
    className?: string
    align?: 'left' | 'right'
    contentTranslate?: string
}

export const homeBanners: HomeBanner[] = [
    {
        id: 'banner-1',
        desktopSrc: '/img/banner/banner-1.jfif',
        mobileSrc: '/img/banner/bannerMobile1.jfif',
        alt: 'Obtén un crédito diario o semanal',
        ctaLabel: 'Obténlo Ahora',
        ctaHref: '#solicitar',
        align: 'right',
        contentTranslate: 'translate-y-25 md:translate-y-5 lg:translate-y-5',
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
        desktopSrc: '/img/banner/banner-2.jfif',
        mobileSrc: '/img/banner/bannerMobile2.jfif',
        alt: 'Crédito para lo que deseas',
        ctaLabel: 'Obténlo Ahora',
        ctaHref: '#solicitar',
        align: 'left',
        contentTranslate: 'translate-y-20 md:translate-y-5',
        kickerParts: [
            { text: 'Crédito para aquello que más' },
            { text: ' deseas', highlight: true },
            { text: ' o ' },
            { text: 'quieres', highlight: true },
        ],
    },
    {
        id: 'banner-3',
        desktopSrc: '/img/banner/banner-3.jfif',
        mobileSrc: '/img/banner/bannerMobile3.jfif',
        alt: 'Crédito Comadres',
        ctaLabel: 'Solicita ahora',
        ctaHref: '#solicitar',
        align: 'left',
        contentTranslate: 'translate-y-35 sm:translate-y-50 md:translate-y-30 lg:translate-y-40 xl:translate-y-60 2xl:translate-y-80',
        kickerParts: [],
    },
]
