export type VacancyKey = 'coord' | 'manager' | 'submanager' | 'credmanager'

export type VacancyPayload = {
    vacancy: VacancyKey

    nombre: string
    fecha_nacimiento: string
    telefono: string
    correo: string
    sucursal: string
    escolaridad: string

    // coord extras
    office_nivel?: string
    manejo_efectivo?: 'Si' | 'No'
    monto_maximo?: number | null
    cortes_arqueos?: 'Si' | 'No'

    // manager/submanager extras
    moto?: 'Si' | 'No'
    licencia?: 'Si' | 'No'
    personal?: 'Si' | 'No'
    indicadores?: 'Si' | 'No'
    cobranza?: 'Si' | 'No'

    // credmanager extras
    moto_anios?: number | null
    ventas?: 'Si' | 'No'
    atencion_cliente?: 'Si' | 'No'
}
