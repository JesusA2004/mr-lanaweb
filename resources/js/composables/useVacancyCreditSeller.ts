import { computed, reactive, ref, watch } from 'vue'
import axios from 'axios'

type YesNo = '' | 'si' | 'no'
type Prioridad = '' | 'colocar_muchos' | 'colocar_bien_cobrar' | 'solo_vender'

type SubmitResult =
  | { ok: true; message: string }
  | { ok: false; message: string; status?: number }

const CV_MAX_MB = 5
const CV_MAX_BYTES = CV_MAX_MB * 1024 * 1024

function validateEmail(v: string) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((v || '').trim())
}

function normalizeTelefono(v: string) {
  return (v || '').replace(/\D/g, '').slice(0, 10)
}

function formatBytes(bytes: number) {
  const mb = bytes / 1024 / 1024
  return `${mb.toFixed(2)} MB`
}

export function useVacancyCreditSeller(endpoint: string) {
  const form = reactive({
    nombre: '',
    fecha_nacimiento: '', // YYYY-MM-DD
    telefono: '',
    correo: '',
    sucursal: '',
    escolaridad: '',
    office: '',

    // 5 preguntas clave
    p1_ventas_cambaceo: '' as YesNo,
    p2_cobranza_campo: '' as YesNo,
    p3_moto_licencia: '' as YesNo,
    p4_trabajo_100_calle: '' as YesNo,
    p5_prioridad_credito: '' as Prioridad,
  })

  const errors = reactive<Record<string, string>>({})
  const submitError = ref('')
  const submitOk = ref('')
  const sending = ref(false)

  // CV opcional
  const cvFile = ref<File | null>(null)
  const cvName = computed(() => cvFile.value?.name || '')

  function clearAlerts() {
    submitError.value = ''
    submitOk.value = ''
  }

  function clearFieldError(key: string) {
    if (errors[key]) delete errors[key]
  }

  function setFieldError(key: string, msg: string) {
    errors[key] = msg
  }

  // Gate: si P1 = "no", bloquea todo
  const blockedByP1 = computed(() => form.p1_ventas_cambaceo === 'no')
  const blockMessage = computed(() =>
    blockedByP1.value ? 'Para este puesto se requiere experiencia REAL en ventas de campo/cambaceo.' : ''
  )

  function onTelefonoInput(e: Event) {
    const el = e.target as HTMLInputElement
    form.telefono = normalizeTelefono(el.value)
    clearAlerts()
    clearFieldError('telefono')
  }

  function onCvChange(file: File | null) {
    clearAlerts()
    clearFieldError('cv')

    if (!file) {
      cvFile.value = null
      return
    }

    const name = (file.name || '').toLowerCase()
    const isPdf = file.type === 'application/pdf' || name.endsWith('.pdf')
    if (!isPdf) {
      cvFile.value = null
      setFieldError('cv', 'Solo se permite PDF.')
      return
    }

    if (file.size > CV_MAX_BYTES) {
      cvFile.value = null
      setFieldError('cv', `El PDF excede ${CV_MAX_MB}MB. Tamaño actual: ${formatBytes(file.size)}`)
      return
    }

    cvFile.value = file
  }

  function resetErrors() {
    Object.keys(errors).forEach((k) => delete errors[k])
  }

  function validate(): boolean {
    clearAlerts()
    resetErrors()

    if (!form.nombre.trim()) setFieldError('nombre', 'Campo obligatorio')
    if (!form.fecha_nacimiento) setFieldError('fecha_nacimiento', 'Campo obligatorio')

    form.telefono = normalizeTelefono(form.telefono)
    if (!form.telefono) setFieldError('telefono', 'Campo obligatorio')
    else if (form.telefono.length !== 10) setFieldError('telefono', 'Deben ser 10 dígitos')

    if (!form.correo.trim()) setFieldError('correo', 'Campo obligatorio')
    else if (!validateEmail(form.correo)) setFieldError('correo', 'Correo inválido')

    if (!form.sucursal) setFieldError('sucursal', 'Campo obligatorio')
    if (!form.escolaridad.trim()) setFieldError('escolaridad', 'Campo obligatorio')
    if (!form.office.trim()) setFieldError('office', 'Campo obligatorio')

    //  P1 requerido siempre
    if (!form.p1_ventas_cambaceo) setFieldError('p1_ventas_cambaceo', 'Selecciona una opción')

    // Si P1 = no, no validamos el resto (porque está bloqueado)
    if (!blockedByP1.value) {
      if (!form.p2_cobranza_campo) setFieldError('p2_cobranza_campo', 'Selecciona una opción')
      if (!form.p3_moto_licencia) setFieldError('p3_moto_licencia', 'Selecciona una opción')
      if (!form.p4_trabajo_100_calle) setFieldError('p4_trabajo_100_calle', 'Selecciona una opción')
      if (!form.p5_prioridad_credito) setFieldError('p5_prioridad_credito', 'Selecciona una opción')
    }

    // CV opcional ya validado en onCvChange, pero reforzamos
    if (cvFile.value) {
      const name = (cvFile.value.name || '').toLowerCase()
      const isPdf = cvFile.value.type === 'application/pdf' || name.endsWith('.pdf')
      if (!isPdf) setFieldError('cv', 'Solo se permite PDF.')
      if (cvFile.value.size > CV_MAX_BYTES) setFieldError('cv', `El PDF excede ${CV_MAX_MB}MB.`)
    }

    return Object.keys(errors).length === 0
  }

  const submitDisabled = computed(() => sending.value)

  async function submit(): Promise<SubmitResult> {
    if (sending.value) return { ok: false, message: 'Envío en proceso.' }

    // Gate inmediato
    if (blockedByP1.value) {
      setFieldError('p1_ventas_cambaceo', 'Este puesto requiere ventas de campo/cambaceo.')
      return { ok: false, message: blockMessage.value || 'No puedes continuar.' }
    }

    if (!validate()) {
      submitError.value = 'Revisa los campos marcados antes de enviar.'
      return { ok: false, message: submitError.value }
    }

    sending.value = true
    clearAlerts()

    try {
      const fd = new FormData()
      fd.append('nombre', form.nombre.trim())
      fd.append('fecha_nacimiento', form.fecha_nacimiento)
      fd.append('telefono', normalizeTelefono(form.telefono))
      fd.append('correo', form.correo.trim())
      fd.append('sucursal', form.sucursal)
      fd.append('escolaridad', form.escolaridad.trim())
      fd.append('office', form.office.trim())

      //  5 preguntas
      fd.append('p1_ventas_cambaceo', form.p1_ventas_cambaceo)
      fd.append('p2_cobranza_campo', form.p2_cobranza_campo)
      fd.append('p3_moto_licencia', form.p3_moto_licencia)
      fd.append('p4_trabajo_100_calle', form.p4_trabajo_100_calle)
      fd.append('p5_prioridad_credito', form.p5_prioridad_credito)

      if (cvFile.value) fd.append('cv', cvFile.value)

      const res = await axios.post(endpoint, fd, {
        timeout: 20000,
        headers: {
          Accept: 'application/json',
          'Content-Type': 'multipart/form-data',
        },
      })

      const msg = res?.data?.message || 'Listo. La postulación se envió correctamente.'
      submitOk.value = msg
      return { ok: true, message: msg }
    } catch (err: any) {
      const status = err?.response?.status
      const backendMsg = err?.response?.data?.message

      // field errors (Laravel)
      const fieldErrors = err?.response?.data?.errors
      if (fieldErrors && typeof fieldErrors === 'object') {
        Object.keys(fieldErrors).forEach((k) => {
          const msg = Array.isArray(fieldErrors[k]) ? fieldErrors[k][0] : String(fieldErrors[k])
          errors[k] = msg
        })
      }

      const fallback =
        status === 422
          ? 'Hay campos inválidos. Revisa los marcados.'
          : status
            ? `Error del servidor (${status}).`
            : 'No hubo respuesta del servidor (timeout/red).'

      const finalMsg = backendMsg || fallback
      submitError.value = finalMsg

      return { ok: false, message: finalMsg, status }
    } finally {
      sending.value = false
    }
  }

  // Mantén siempre 10 dígitos aunque peguen basura
  watch(
    () => form.telefono,
    (v) => {
      form.telefono = normalizeTelefono(v)
    }
  )

  return {
    form,
    errors,
    blockedByP1,
    blockMessage,
    submitError,
    submitOk,
    cvName,
    onCvChange,
    onTelefonoInput,
    clearFieldError,
    clearAlerts,
    sending,
    submitDisabled,
    submit,
  }
}
