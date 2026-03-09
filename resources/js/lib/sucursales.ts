// resources/js/lib/sucursales.ts
export const SUCURSALES = [
    'Aguascalientes',
    'Atlixco',
    'Atlacomulco',
    'Cuernavaca',
    'Cordoba',
    'Miacatlán',
    'Orizaba',
    'Pachuca',
    'San Luis Potosí',
    'Tlaxcala',
    'Tula',
    'Tulancingo',
] as const

export type Sucursal = (typeof SUCURSALES)[number]
