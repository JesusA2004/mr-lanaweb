export type Branch = {
    id: string
    zone: 'Centro' | 'Golfo' | 'Norte' | 'Bajio' | 'Sureste' | 'Occidente'
    name: string
    city: string
    state: string
    address: string
    phones?: string[]
    mapUrl?: string
  }
  
  export const zones = [
    { key: 'Centro', label: 'Zona Centro' },
    { key: 'Golfo', label: 'Zona Golfo' },
    { key: 'Norte', label: 'Zona Norte' },
    { key: 'Bajio', label: 'Zona Bajío' },
    { key: 'Sureste', label: 'Zona Sureste' },
    { key: 'Occidente', label: 'Zona Occidente' },
  ] as const
  
  export const branches: Branch[] = [
    {
      id: 'cvaca-centro',
      zone: 'Centro',
      name: 'Cuernavaca Centro',
      city: 'Cuernavaca',
      state: 'Morelos',
      address: 'Centro, Cuernavaca, Mor.',
      phones: ['777 000 0000'],
      mapUrl: 'https://maps.google.com',
    },
    {
      id: 'cdmx',
      zone: 'Centro',
      name: 'CDMX',
      city: 'Ciudad de México',
      state: 'CDMX',
      address: 'CDMX',
      phones: ['55 0000 0000'],
      mapUrl: 'https://maps.google.com',
    },
    {
      id: 'veracruz',
      zone: 'Golfo',
      name: 'Veracruz',
      city: 'Veracruz',
      state: 'Veracruz',
      address: 'Veracruz, Ver.',
      phones: ['229 000 0000'],
      mapUrl: 'https://maps.google.com',
    },
    {
      id: 'monterrey',
      zone: 'Norte',
      name: 'Monterrey',
      city: 'Monterrey',
      state: 'Nuevo León',
      address: 'Monterrey, N.L.',
      phones: ['81 0000 0000'],
      mapUrl: 'https://maps.google.com',
    },
  ]
  