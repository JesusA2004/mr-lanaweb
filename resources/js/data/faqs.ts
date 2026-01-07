export type FaqItem = {
    id: string
    q: string
    a: string
    category?: string
  }
  
  export const faqs: FaqItem[] = [
    {
      id: 'req-1',
      q: '¿Qué necesito para solicitar?',
      a: 'Nombre completo, teléfono, correo, dirección y seleccionar sucursal. En algunos casos se solicita información adicional.',
      category: 'Solicitud',
    },
    {
      id: 'time-1',
      q: '¿Cuánto tarda el proceso?',
      a: 'Depende del caso, pero buscamos que sea rápido y claro desde el primer contacto.',
      category: 'Proceso',
    },
    {
      id: 'buro-1',
      q: '¿Es sin buró?',
      a: 'Nuestro enfoque es flexible. La evaluación depende del producto y el perfil.',
      category: 'Evaluación',
    },
  ]
  