// resources/js/composables/useVacancyCoordinator.ts
import { computed, reactive, ref } from 'vue'
import { differenceInYears, isValid, parseISO } from 'date-fns'
import { useVacancySubmit } from '@/composables/useVacancySubmit'
import { useVacancyValidation, type Rule, enforceMaxDigits } from '@/composables/useVacancyValidation'

type YesNo = '' | 'si' | 'no'
type CierreFaltante = '' | 'detengo_reporto' | 'ajusto' | 'dejo_despues'

export type CoordinatorForm = {
  // Base
  nombre: string
  fecha_nacimiento: string // YYYY-MM-DD
  telefono: string
  correo: string
  sucursal: string
  escolaridad: string
  office: string

  // Preguntas
  p1_resguardo_efectivo: YesNo
  p2_expedientes: YesNo
  p3_cuadres_cierre: YesNo
  p4_faltante: CierreFaltante
  p5_responsabilidad: YesNo
}

export function useVacancyCoordinator(apiUrl = '/api/vacantes/coordinadora') {
  const form = reactive<CoordinatorForm>({
    nombre: '',
    fecha_nacimiento: '',
    telefono: '',
    correo: '',
    sucursal: '',
    escolaridad: '',
    office: '',

    p1_resguardo_efectivo: '',
    p2_expedientes: '',
    p3_cuadres_cierre: '',
    p4_faltante: '',
    p5_responsabilidad: '',
  })

  const submitError = ref('')
  const submitOk = ref('')

  const submitApi = useVacancySubmit()
  const { errors, validate, clear: clearErrors } = useVacancyValidation<CoordinatorForm>()

  // CV opcional (pero validado si existe)
  const cvFile = ref<File | null>(null)
  const cvName = ref('')
  const CV_MAX_MB = 5
  const CV_MAX_BYTES = CV_MAX_MB * 1024 * 1024

  function clearAlerts() {
    submitError.value = ''
    submitOk.value = ''
    submitApi.resetMessages()
  }

  function clearFieldError(key: keyof CoordinatorForm | 'cv') {
    clearAlerts()
    if (errors[key as string]) delete errors[key as string]
  }

  function onCvChange(file: File | null) {
    clearAlerts()
    if (errors.cv) delete errors.cv
    cvFile.value = null
    cvName.value = ''

    if (!file) return // opcional

    const name = (file.name || '').toLowerCase()
    const isPdf = file.type === 'application/pdf' || name.endsWith('.pdf')
    if (!isPdf) {
      errors.cv = 'El CV debe ser un PDF.'
      return
    }
    if (file.size > CV_MAX_BYTES) {
      errors.cv = `El CV no debe exceder ${CV_MAX_MB}MB.`
      return
    }

    cvFile.value = file
    cvName.value = file.name
  }

  // input hard-stop: 10 dígitos siempre
  function onTelefonoInput(e: Event) {
    const el = e.target as HTMLInputElement
    const v = enforceMaxDigits(el.value, 10)
    form.telefono = v
    el.value = v
    clearFieldError('telefono')
  }

  const p4Human = computed(() => {
    switch (form.p4_faltante) {
      case 'detengo_reporto':
        return 'Detienes el cierre, documentas y reportas de inmediato'
      case 'ajusto':
        return 'Ajustas para cuadrar'
      case 'dejo_despues':
        return 'Lo dejas para el día siguiente'
      default:
        return '—'
    }
  })

  // reglas
  const rules: Rule<CoordinatorForm>[] = [
    { field: 'nombre', label: 'Nombre completo', required: true, trim: true },
    { field: 'fecha_nacimiento', label: 'Fecha de nacimiento', required: true },
    { field: 'telefono', label: 'Teléfono', required: true, digitsOnly: true, digitsExact: 10, normalizeDigits: true },
    { field: 'correo', label: 'Correo', required: true, isEmail: true, trim: true },
    { field: 'sucursal', label: 'Sucursal', required: true },
    { field: 'escolaridad', label: 'Escolaridad', required: true, trim: true },
    { field: 'office', label: 'Paquetería Office', required: true, trim: true },

    { field: 'p1_resguardo_efectivo', label: 'Pregunta 1', required: true },
    { field: 'p2_expedientes', label: 'Pregunta 2', required: true },
    { field: 'p3_cuadres_cierre', label: 'Pregunta 3', required: true },
    { field: 'p4_faltante', label: 'Pregunta 4', required: true },
    { field: 'p5_responsabilidad', label: 'Pregunta 5', required: true },
  ]

  function validateExtraBusinessRules(): boolean {
    // +18 (mismo estándar que gerente)
    if (form.fecha_nacimiento) {
      const d = parseISO(form.fecha_nacimiento)
      if (!isValid(d)) {
        errors.fecha_nacimiento = 'Fecha inválida'
        return false
      }
      if (differenceInYears(new Date(), d) < 18) {
        errors.fecha_nacimiento = 'Debes ser mayor de 18 años'
        return false
      }
    }

    // si hay CV, ya se validó en onCvChange, pero por seguridad revalida
    if (cvFile.value) {
      const name = (cvFile.value.name || '').toLowerCase()
      const isPdf = cvFile.value.type === 'application/pdf' || name.endsWith('.pdf')
      if (!isPdf) {
        errors.cv = 'El CV debe ser un PDF.'
        return false
      }
      if (cvFile.value.size > CV_MAX_BYTES) {
        errors.cv = `El CV no debe exceder ${CV_MAX_MB}MB.`
        return false
      }
    }

    return true
  }

  async function submit(): Promise<{ ok: boolean; message: string }> {
    if (submitApi.loading.value) return { ok: false, message: 'Envío en progreso.' }

    clearAlerts()
    clearErrors()

    // normaliza
    form.telefono = enforceMaxDigits(form.telefono, 10)

    const ok = validate(form, rules)
    if (!ok) {
      const msg = 'Revisar los campos marcados antes de enviar.'
      submitError.value = msg
      return { ok: false, message: msg }
    }

    if (!validateExtraBusinessRules()) {
      const msg = submitError.value || 'Revisar los campos marcados antes de enviar.'
      submitError.value = msg
      return { ok: false, message: msg }
    }

    const fd = new FormData()
    fd.append('nombre', form.nombre.trim())
    fd.append('fecha_nacimiento', form.fecha_nacimiento)
    fd.append('telefono', form.telefono)
    fd.append('correo', form.correo.trim())
    fd.append('sucursal', form.sucursal)
    fd.append('escolaridad', form.escolaridad.trim())
    fd.append('office', form.office.trim())

    fd.append('p1_resguardo_efectivo', form.p1_resguardo_efectivo)
    fd.append('p2_expedientes', form.p2_expedientes)
    fd.append('p3_cuadres_cierre', form.p3_cuadres_cierre)
    fd.append('p4_faltante', form.p4_faltante)
    fd.append('p5_responsabilidad', form.p5_responsabilidad)

    if (cvFile.value) fd.append('cv', cvFile.value)

    const result = await submitApi.submit(apiUrl, { payload: fd, timeoutMs: 20000 })

    if (result.ok) {
      submitOk.value = result.message
      // limpia CV (opcional)
      cvFile.value = null
      cvName.value = ''
      return { ok: true, message: result.message }
    }

    if (result.status === 422 && result.fieldErrors) {
      Object.keys(result.fieldErrors).forEach((k) => {
        errors[k] = result.fieldErrors![k]
      })
    }

    submitError.value = result.message
    return { ok: false, message: result.message }
  }

  return {
    form,
    errors,
    p4Human,

    // alerts
    submitError,
    submitOk,

    // cv
    cvFile,
    cvName,
    onCvChange,

    // input
    onTelefonoInput,
    clearFieldError,
    clearAlerts,

    // submit
    sending: submitApi.loading,
    submit,
  }
}
