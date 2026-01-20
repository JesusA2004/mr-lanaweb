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
    id: 'cuernavaca',
    zone: 'Centro',
    name: 'Sucursal Cuernavaca',
    city: 'Cuernavaca',
    state: 'Morelos',
    address: 'Privada Reforma #751-D, Col. Tlaltenango, Cuernavaca, Morelos, C.P. 62170',
    phones: [],
  },
  {
    id: 'miacatlan',
    zone: 'Centro',
    name: 'Sucursal Miacatlán',
    city: 'Miacatlán',
    state: 'Morelos',
    address: 'Av. Morelos S/N, Col. Centro, Miacatlán, Morelos, C.P. 62600',
    phones: ['737 688 1772'],
  },
  {
    id: 'tenango',
    zone: 'Centro',
    name: 'Sucursal Tenango',
    city: 'Tenango del Valle',
    state: 'Estado de México',
    address: 'Benito Juárez #203, Col. Cruz Verde, Tenango del Valle, C.P. 52300',
    phones: ['559 054 9617'],
  },
  {
    id: 'atlixco',
    zone: 'Centro',
    name: 'Sucursal Atlixco',
    city: 'Atlixco',
    state: 'Puebla',
    address: 'Blvd. Niños Héroes #908-B, Col. Revolución, Atlixco, Puebla, C.P. 74270',
    phones: ['222 944 6532'],
  },
  {
    id: 'ixtlahuaca',
    zone: 'Centro',
    name: 'Sucursal Ixtlahuaca',
    city: 'Ixtlahuaca',
    state: 'Estado de México',
    address: 'Av. Gustavo Baz Prada #406, Ixtlahuaca, Estado de México, C.P. 50740',
    phones: ['712 688 1615'],
  },

  {
    id: 'cordoba',
    zone: 'Golfo',
    name: 'Sucursal Córdoba',
    city: 'Córdoba',
    state: 'Veracruz',
    address: 'Av. 11 #1305 local 20, Col. Centro, Córdoba, Veracruz, C.P. 94500',
    phones: ['271 344 2933'],
  },
  {
    id: 'orizaba',
    zone: 'Golfo',
    name: 'Sucursal Orizaba',
    city: 'Orizaba',
    state: 'Veracruz',
    address: 'Oriente 6, #851, Int. 10 y 11, Esq. Sur 17, Col. Centro, Orizaba, Veracruz, C.P. 94300',
    phones: [],
  },
  {
    id: 'huamantla',
    zone: 'Golfo',
    name: 'Sucursal Huamantla',
    city: 'Huamantla',
    state: 'Tlaxcala',
    address: 'Calle Morelos Oriente #311, local 15, Col. Centro, Huamantla, Tlaxcala, C.P. 90500',
    phones: [],
  },
  {
    id: 'tlaxcala',
    zone: 'Golfo',
    name: 'Sucursal Tlaxcala',
    city: 'Tlaxcala',
    state: 'Tlaxcala',
    address: 'Carr. Ocotlán–Chiautempan #134, Col. La Joya Centro, Tlaxcala, C.P. 90114',
    phones: ['246 312 8179'],
  },

  {
    id: 'atlacomulco',
    zone: 'Norte',
    name: 'Sucursal Atlacomulco',
    city: 'Atlacomulco',
    state: 'Estado de México',
    address: 'Juan N. Reséndiz 5, Col. Centro, Atlacomulco, Edo. Méx., C.P. 50450',
    phones: ['712 597 5776', '712 688 2923'],
  },

  {
    id: 'san-juan-del-rio',
    zone: 'Bajio',
    name: 'Sucursal San Juan del Río',
    city: 'San Juan del Río',
    state: 'Querétaro',
    address: 'Calle Corregidora #68, Col. Centro, San Juan del Río, Querétaro.',
    phones: ['427 366 8764'],
  },
  {
    id: 'san-luis-potosi',
    zone: 'Bajio',
    name: 'Sucursal San Luis Potosí',
    city: 'San Luis Potosí',
    state: 'San Luis Potosí',
    address: 'Plaza Coronel, Prolongación Coronel Romero #110, Col. Alamitos, San Luis Potosí, C.P. 78280',
    phones: [],
  },
  {
    id: 'tula',
    zone: 'Bajio',
    name: 'Sucursal Tula',
    city: 'Tula de Allende',
    state: 'Hidalgo',
    address: 'Boulevard Tula Iturbe #100, Col. Villas del Salitre, Tula de Allende, Hidalgo.',
    phones: ['773 732 2376'],
  },
]
