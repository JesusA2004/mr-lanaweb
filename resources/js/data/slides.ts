export type Slide = {
    id: string
    title: string
    subtitle: string
    ctaLabel: string
    ctaHref: string
    image?: string
  }
  
  export const slides: Slide[] = [
    {
      id: 's1',
      title: 'Impulsa tu negocio con crédito a tu ritmo',
      subtitle: 'Proceso claro, atención rápida y sucursal cercana.',
      ctaLabel: 'Solicitar ahora',
      ctaHref: '#solicitar',
      image: '/img/slides/slide-1.jpg',
    },
    {
      id: 's2',
      title: 'Financiamiento para crecer sin fricción',
      subtitle: 'Te acompañamos de inicio a fin.',
      ctaLabel: 'Ver sucursales',
      ctaHref: '/sucursales',
      image: '/img/slides/slide-2.jpg',
    },
  ]
  