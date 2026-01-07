export type Vacancy = {
    id: string
    role: string
    location?: string
    bullets: string[]
  }
  
  export const vacancies: Vacancy[] = [
    {
      id: 'coord',
      role: 'Coordinador(a)',
      location: 'Sucursal',
      bullets: [
        'Coordinar operación diaria y cumplimiento de metas.',
        'Asegurar calidad de atención y seguimiento a clientes.',
        'Reportes y control básico de indicadores.',
      ],
    },
    {
      id: 'gerente',
      role: 'Gerente',
      location: 'Sucursal',
      bullets: [
        'Liderar equipo comercial y operativo.',
        'Estrategia local para crecimiento y retención.',
        'Ejecución y control de objetivos.',
      ],
    },
    {
      id: 'subgerente',
      role: 'Subgerente',
      location: 'Sucursal',
      bullets: [
        'Soporte a gerencia, seguimiento de pipeline y clientes.',
        'Control de operación y cumplimiento de procesos.',
      ],
    },
    {
      id: 'gestor',
      role: 'Gestor(a) de Crédito',
      location: 'Sucursal / Campo',
      bullets: [
        'Prospección y seguimiento a solicitudes.',
        'Validación básica y acompañamiento al cliente.',
      ],
    },
  ]
  