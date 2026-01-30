// resources/js/composables/useVacancySubManager.ts
import { computed, reactive, ref, watch } from 'vue'
import { differenceInYears, isValid, parseISO } from 'date-fns'
import { useVacancySubmit } from '@/composables/useVacancySubmit'
import { useVacancyValidation, type Rule, enforceMaxDigits } from '@/composables/useVacancyValidation'

type YesNo = '' | 'si' | 'no'
type P4 = '' | 'analizo' | 'reporteo' | 'presiono'

export type SubManagerForm = {
  nombre: string
  fecha_nacimiento: string
  telefono: string
  correo: string
  sucursal: string
  escolaridad: string
  office: string
  experiencia_anios: string
  liderazgo: YesNo

  p1_cartera: YesNo
  p2_campo: YesNo
  p3_indicadores: YesNo
  p4_accion: P4
  p5_presion: YesNo
}

export function useVacancySubManager(apiUrl = '/api/vacantes/subgerente') {
  // ====== form state
  const form = reactive<SubManagerForm>({
    nombre: '',
    fecha_nacimiento: '',
    telefono: '',
    correo: '',
    sucursal: '',
    escolaridad: '',
    office: '',
    experiencia_anios: '',
    liderazgo: '',

    p1_cartera: '',
    p2_campo: '',
    p3_indicadores: '',
    p4_accion: '',
    p5_presion: '',
  })

  // ====== UI state
  const submitError = ref('')
  const submitOk = ref('')

  // ====== submit api (motor)
  const submitApi = useVacancySubmit()

  function clearAlerts() {
    submitError.value = ''
    submitOk.value = ''
    submitApi.resetMessages()
  }

  // ====== validation (general)
  const { errors, validate, clear: clearErrors } = useVacancyValidation<SubManagerForm>()

  const blockedByP1 = computed(() => form.p1_cartera === 'no')

  const blockMessage = computed(() =>
    blockedByP1.value
      ? 'Para este puesto necesitamos experiencia directa con cartera de crédito (colocación y cobranza). No podrás enviar tu postulación hasta contar con esa experiencia.'
      : ''
  )

  // Si está bloqueado, NO tiene sentido conservar errores de las preguntas deshabilitadas
  function clearBlockedQuestionErrors() {
    delete errors.p2_campo
    delete errors.p3_indicadores
    delete errors.p4_accion
    delete errors.p5_presion
  }

  watch(
    () => form.p1_cartera,
    (v) => {
      clearAlerts()
      // si el usuario dijo "no", limpia errores y (opcional) limpia respuestas para evitar basura
      if (v === 'no') {
        clearBlockedQuestionErrors()
        form.p2_campo = ''
        form.p3_indicadores = ''
        form.p4_accion = ''
        form.p5_presion = ''
      }
      // si vuelve a "si", solo limpia el error de p1 si existía
      if (v === 'si') {
        if (errors.p1_cartera) delete errors.p1_cartera
      }
    }
  )

  // ====== reglas: base + cuestionario condicional
  const rulesBase: Rule<SubManagerForm>[] = [
    { field: 'nombre', label: 'Nombre completo', required: true },
    { field: 'fecha_nacimiento', label: 'Fecha de nacimiento', required: true },
    { field: 'telefono', label: 'Teléfono', required: true, digitsOnly: true, digitsExact: 10, normalizeDigits: true },
    { field: 'correo', label: 'Correo', required: true, isEmail: true },
    { field: 'sucursal', label: 'Sucursal', required: true },
    { field: 'escolaridad', label: 'Escolaridad', required: true },
    { field: 'office', label: 'Nivel de paquetería Office', required: true },
    { field: 'experiencia_anios', label: 'Años de experiencia', required: true, digitsOnly: true, digitsMax: 2, normalizeDigits: true },
    { field: 'liderazgo', label: 'Liderazgo', required: true },

    // gate
    { field: 'p1_cartera', label: 'Pregunta 1', required: true },
  ]

  const rulesCuestionario: Rule<SubManagerForm>[] = [
    { field: 'p2_campo', label: 'Pregunta 2', required: true },
    { field: 'p3_indicadores', label: 'Pregunta 3', required: true },
    { field: 'p4_accion', label: 'Pregunta 4', required: true },
    { field: 'p5_presion', label: 'Pregunta 5', required: true },
  ]

  function clearFieldError(key: keyof SubManagerForm | 'cv') {
    clearAlerts()
    if (errors[key as string]) delete errors[key as string]
  }

  // ====== CV state
  const cvFile = ref<File | null>(null)
  const cvName = ref('')
  const CV_MAX_MB = 5
  const CV_MAX_BYTES = CV_MAX_MB * 1024 * 1024

  function onCvChange(file: File | null) {
    clearAlerts()
    cvFile.value = null
    cvName.value = ''
    if (errors.cv) delete errors.cv

    if (!file) return

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

  // ====== normalizers (solo números y topes)
  function onTelefonoInput(e: Event) {
    const el = e.target as HTMLInputElement
    const v = enforceMaxDigits(el.value, 10)
    form.telefono = v
    el.value = v
    clearFieldError('telefono')
  }

  function onExperienciaInput(e: Event) {
    const el = e.target as HTMLInputElement
    const v = enforceMaxDigits(el.value, 2) // años (0-99)
    form.experiencia_anios = v
    el.value = v
    clearFieldError('experiencia_anios')
  }

  function validateExtraBusinessRules(): boolean {
    // +18
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

    // gate: p1 = no (bloquea envío; NO valida P2-P5)
    if (form.p1_cartera === 'no') {
      clearBlockedQuestionErrors()
      submitError.value = blockMessage.value || 'Para este puesto necesitamos experiencia directa con cartera de crédito.'
      return false
    }

    return true
  }

  // ====== submit
async function submit(): Promise<{ ok: boolean; message: string }> {
  if (submitApi.loading.value) {
    return { ok: false, message: 'Envío en progreso.' }
  }

  clearAlerts()
  clearErrors()

  // normaliza antes de validar
  form.telefono = enforceMaxDigits(form.telefono, 10)
  form.experiencia_anios = enforceMaxDigits(form.experiencia_anios, 2)

  // 1) valida base (incluye P1)
  const okBase = validate(form, rulesBase)
  if (!okBase) {
    const msg = 'Revisar los campos marcados antes de enviar.'
    submitError.value = msg
    return { ok: false, message: msg }
  }

  // 2) reglas extra (18+ y gate)
  //    - OJO: validateExtraBusinessRules ya pone submitError cuando p1=no o edad inválida
  if (!validateExtraBusinessRules()) {
    const msg = submitError.value || 'Revisar los campos marcados antes de enviar.'
    submitError.value = msg
    return { ok: false, message: msg }
  }

  // 3) SOLO si NO está bloqueado, valida P2–P5
  if (!blockedByP1.value) {
    const okQuiz = validate(form, rulesCuestionario)
    if (!okQuiz) {
      const msg = 'Revisar los campos marcados antes de enviar.'
      submitError.value = msg
      return { ok: false, message: msg }
    }
  } else {
    // Si está bloqueado, por negocio NO debe pasar de aquí
    const msg = blockMessage.value || 'Para este puesto necesitas experiencia directa con cartera de crédito.'
    submitError.value = msg
    return { ok: false, message: msg }
  }

  // arma payload multipart (por CV)
  const fd = new FormData()
  fd.append('nombre', form.nombre)
  fd.append('fecha_nacimiento', form.fecha_nacimiento)
  fd.append('telefono', form.telefono)
  fd.append('correo', form.correo)
  fd.append('sucursal', form.sucursal)
  fd.append('escolaridad', form.escolaridad)
  fd.append('office', form.office)
  fd.append('experiencia_anios', form.experiencia_anios)
  fd.append('liderazgo', form.liderazgo)

  fd.append('p1_cartera', form.p1_cartera)
  fd.append('p2_campo', form.p2_campo)
  fd.append('p3_indicadores', form.p3_indicadores)
  fd.append('p4_accion', form.p4_accion)
  fd.append('p5_presion', form.p5_presion)

  if (cvFile.value) fd.append('cv', cvFile.value)

  submitApi.loading.value = true
  submitApi.resetMessages()

  try {
    const res = await fetch(apiUrl, {
      method: 'POST',
      headers: { Accept: 'application/json' },
      body: fd,
    })

    // Intenta leer JSON una sola vez
    let data: any = null
    try {
      data = await res.json()
    } catch {
      data = null
    }

    if (!res.ok) {
      const status = res.status
      let msg =
        status === 422
          ? 'Hay campos inválidos. Revisa los marcados.'
          : status
          ? `No se pudo enviar la solicitud (HTTP ${status}). Intenta de nuevo.`
          : 'No se pudo enviar la solicitud. Revisa los datos e inténtalo de nuevo.'

      if (data?.message) msg = data.message

      submitApi.serverError.value = msg
      submitError.value = msg

      // pinta errores del backend si vienen en formato Laravel {errors:{campo:[msg]}}
      const bag = data?.errors
      if (bag && typeof bag === 'object') {
        Object.keys(bag).forEach((k) => {
          const first = Array.isArray(bag[k]) ? bag[k][0] : String(bag[k] ?? '')
          if (first) errors[k] = first
        })
      }

      return { ok: false, message: msg }
    }

    const okMsg = data?.message || 'Listo. La postulación se envió correctamente.'
    submitApi.serverSuccess.value = okMsg
    submitOk.value = okMsg

    // limpia archivo (si quieres también limpiar form, lo hacemos)
    cvFile.value = null
    cvName.value = ''

    return { ok: true, message: okMsg }
  } catch (e: any) {
    const aborted = e?.name === 'AbortError'
    const msg = aborted
      ? 'La solicitud tardó demasiado (timeout). Inténtalo de nuevo.'
      : 'Error de conexión. Inténtalo de nuevo.'

    submitApi.serverError.value = msg
    submitError.value = msg
    return { ok: false, message: msg }
  } finally {
    submitApi.loading.value = false
  }
}

  return {
    // state
    form,
    errors,
    blockedByP1,
    blockMessage,

    // alerts
    submitError,
    submitOk,

    // cv
    cvFile,
    cvName,
    onCvChange,

    // inputs
    onTelefonoInput,
    onExperienciaInput,
    clearFieldError,
    clearAlerts,

    // submit
    sending: submitApi.loading, // compat con tu template
    submit,
  }
}
