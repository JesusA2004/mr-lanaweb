// resources/js/lib/sucursales.ts
export const SUCURSALES = [
    'Aguascalientes',
    'Atlixco',
    'Atlacomulco',
    'Cuernavaca',
    'Cordoba',
    'Huamantla',
    'Ixtlahuaca',
    'Miacatlán',
    'Orizaba',
    'Pachuca',
    'San Luis Potosí',
    'San Juan del Río',
    'Tenango',
    'Tlaxcala',
    'Tula',
    'Tulancingo',
] as const

export type Sucursal = (typeof SUCURSALES)[number]
