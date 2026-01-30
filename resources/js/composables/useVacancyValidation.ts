// resources/js/composables/useVacancyValidation.ts
import { reactive } from 'vue'
import { differenceInYears, parseISO, isValid } from 'date-fns'

export type ErrorsMap<T extends string> = Partial<Record<T, string>>

export type Rule<TForm> = {
  field: keyof TForm & string
  label: string

  required?: boolean
  trim?: boolean

  // email
  isEmail?: boolean

  // longitud general
  minLen?: number
  maxLen?: number

  // solo números / dígitos
  digitsOnly?: boolean
  digitsExact?: number
  digitsMax?: number
  normalizeDigits?: boolean

  // fecha mínima por edad (ej. 18)
  minAgeYears?: number

  // radios/select: valor debe estar en lista
  oneOf?: readonly string[]

  // regla custom
  custom?: (value: any, form: TForm) => true | string
}

function isEmpty(v: unknown) {
  return v === null || v === undefined || String(v).trim() === ''
}

export function isValidEmail(v: string) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((v || '').trim())
}

export function sanitizeDigits(v: string) {
  return (v || '').replace(/\D/g, '')
}

export function enforceMaxDigits(v: string, max: number) {
  return sanitizeDigits(v).slice(0, max)
}

export function useVacancyValidation<TForm extends Record<string, any>>() {
  const errors = reactive<Record<string, string>>({})

  function clear() {
    Object.keys(errors).forEach((k) => delete errors[k])
  }

  // Setter seguro para TS genérico
  function setField(form: TForm, field: keyof TForm & string, v: any) {
    ;(form as Record<string, any>)[field] = v
  }

  function validate(form: TForm, rules: Rule<TForm>[]) {
    clear()

    for (const r of rules) {
      let value: any = (form as Record<string, any>)[r.field]

      // trim opcional
      if (r.trim && typeof value === 'string') {
        value = value.trim()
        setField(form, r.field, value)
      }

      // normalizar dígitos opcional
      if (r.normalizeDigits && value !== null && value !== undefined) {
        const s = String(value)
        const normalized =
          typeof r.digitsMax === 'number' ? enforceMaxDigits(s, r.digitsMax) : sanitizeDigits(s)
        value = normalized
        setField(form, r.field, normalized)
      }

      // required
      if (r.required && isEmpty(value)) {
        errors[r.field] = `${r.label} es obligatorio.`
        continue
      }

      // si está vacío y no es required: saltar
      if (isEmpty(value)) continue

      const s = String(value)

      // email
      if (r.isEmail && !isValidEmail(s)) {
        errors[r.field] = `${r.label} no tiene un formato válido.`
        continue
      }

      // only digits (texto limpio ya o no)
      if (r.digitsOnly && /\D/.test(s)) {
        errors[r.field] = `${r.label} solo acepta números.`
        continue
      }

      // digitsMax
      if (typeof r.digitsMax === 'number') {
        const onlyDigits = sanitizeDigits(s)
        if (onlyDigits.length > r.digitsMax) {
          errors[r.field] = `${r.label} no puede superar ${r.digitsMax} dígitos.`
          continue
        }
      }

      // digitsExact
      if (typeof r.digitsExact === 'number') {
        const onlyDigits = sanitizeDigits(s)
        if (onlyDigits.length !== r.digitsExact) {
          errors[r.field] = `${r.label} debe tener exactamente ${r.digitsExact} dígitos.`
          continue
        }
      }

      // min/max length general
      if (r.minLen && s.length < r.minLen) {
        errors[r.field] = `${r.label} debe tener al menos ${r.minLen} caracteres.`
        continue
      }
      if (r.maxLen && s.length > r.maxLen) {
        errors[r.field] = `${r.label} no puede superar ${r.maxLen} caracteres.`
        continue
      }

      // oneOf
      if (r.oneOf && !r.oneOf.includes(s)) {
        errors[r.field] = `${r.label} es inválido.`
        continue
      }

      // minAgeYears (fecha_nacimiento)
      if (typeof r.minAgeYears === 'number') {
        const d = parseISO(s)
        if (!isValid(d)) {
          errors[r.field] = `${r.label} es inválida.`
          continue
        }
        if (differenceInYears(new Date(), d) < r.minAgeYears) {
          errors[r.field] = `Debes ser mayor de ${r.minAgeYears} años.`
          continue
        }
      }

      // custom
      if (r.custom) {
        const result = r.custom(value, form)
        if (result !== true) {
          errors[r.field] = typeof result === 'string' ? result : `${r.label} es inválido.`
          continue
        }
      }
    }

    return Object.keys(errors).length === 0
  }

  return { errors, validate, clear, sanitizeDigits, enforceMaxDigits, isValidEmail }
}
