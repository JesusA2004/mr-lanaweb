// resources/js/composables/useVacancyValidation.ts
import { reactive } from 'vue'

export type ErrorsMap<T extends string> = Partial<Record<T, string>>

export type Rule<TForm> = {
  field: keyof TForm & string
  label: string
  required?: boolean
  isEmail?: boolean
  minLen?: number
  maxLen?: number
  numericOnly?: boolean
}

function isEmpty(v: unknown) {
  return v === null || v === undefined || String(v).trim() === ''
}

function isValidEmail(v: string) {
  // suficientemente robusto para front (sin pasarse de listo)
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)
}

export function useVacancyValidation<TForm extends Record<string, any>>() {
  const errors = reactive<Record<string, string>>({})

  function clear() {
    Object.keys(errors).forEach((k) => delete errors[k])
  }

  function validate(form: TForm, rules: Rule<TForm>[]) {
    clear()
    for (const r of rules) {
      const value = form[r.field]

      if (r.required && isEmpty(value)) {
        errors[r.field] = `${r.label} es obligatorio.`
        continue
      }

      if (!isEmpty(value)) {
        const s = String(value)

        if (r.numericOnly && /\D/.test(s)) {
          errors[r.field] = `${r.label} solo acepta números.`
          continue
        }

        if (r.minLen && s.length < r.minLen) {
          errors[r.field] = `${r.label} debe tener al menos ${r.minLen} caracteres.`
          continue
        }

        if (r.maxLen && s.length > r.maxLen) {
          errors[r.field] = `${r.label} no puede superar ${r.maxLen} caracteres.`
          continue
        }

        if (r.isEmail && !isValidEmail(s)) {
          errors[r.field] = `${r.label} no tiene un formato válido.`
          continue
        }
      }
    }

    return Object.keys(errors).length === 0
  }

  return { errors, validate, clear }
}
