import { ref } from 'vue'
export type FieldErrors = Record<string, string>

export type SubmitResult =
  | { ok: true; message: string; data?: any }
  | { ok: false; message: string; status?: number; fieldErrors?: FieldErrors }

type SubmitOptions = {
    /**
     * Si mandamos FormData (ej. CV), se detecta automático.
     * Si mandamos JSON, se manda application/json.
     */
    payload?: Record<string, any> | FormData

    // Headers extra
    headers?: Record<string, string>
    timeoutMs?: number
    successMessage?: string
}

function toFieldErrors(bag: any): FieldErrors {
    const out: FieldErrors = {}
    if (!bag || typeof bag !== 'object') return out
    for (const k of Object.keys(bag)) {
        const v = bag[k]
        const msg = Array.isArray(v) ? v[0] : String(v ?? '')
        if (msg) out[k] = msg
    }
    return out
}

async function safeJson(res: Response) {
    try {
        return await res.json()
    } catch {
        return null
    }
}

export function useVacancySubmit() {
  const loading = ref(false)
  const serverError = ref<string>('')   // mensaje para FormAlert
  const serverSuccess = ref<string>('') // mensaje para FormAlert

  function resetMessages() {
    serverError.value = ''
    serverSuccess.value = ''
  }

  /**
   * submit(url, payloadOrOptions)
   *
   * Ejemplos:
   *  submit('/api/vacantes/subgerente', { nombre:'...' })
   *  submit('/api/vacantes/subgerente', { payload: fd })
   */
  async function submit(
    url: string,
    payloadOrOptions: Record<string, any> | FormData | SubmitOptions
  ): Promise<SubmitResult> {
    loading.value = true
    resetMessages()

    const opts: SubmitOptions =
      payloadOrOptions instanceof FormData
        ? { payload: payloadOrOptions }
        : (payloadOrOptions as SubmitOptions)?.payload !== undefined ||
          (payloadOrOptions as SubmitOptions)?.timeoutMs !== undefined ||
          (payloadOrOptions as SubmitOptions)?.headers !== undefined
        ? (payloadOrOptions as SubmitOptions)
        : { payload: payloadOrOptions as Record<string, any> }

    const payload = opts.payload ?? {}
    const timeoutMs = opts.timeoutMs ?? 20000
    const successMessage = opts.successMessage ?? 'Listo: solicitud enviada correctamente.'

    const controller = new AbortController()
    const t = setTimeout(() => controller.abort(), timeoutMs)

    try {
      const isFD = payload instanceof FormData

      const headers: Record<string, string> = {
        Accept: 'application/json',
        ...(opts.headers ?? {}),
      }

      // Si es JSON, ponemos content-type. Si es FormData, NO, porque el browser arma el boundary.
      if (!isFD) headers['Content-Type'] = 'application/json'

      const res = await fetch(url, {
        method: 'POST',
        headers,
        body: isFD ? payload : JSON.stringify(payload),
        signal: controller.signal,
      })

      const data = await safeJson(res)

      if (!res.ok) {
        const status = res.status

        // Default message
        let msg =
          status === 422
            ? 'Hay campos inválidos. Revisa los marcados.'
            : status
            ? `No se pudo enviar la solicitud (HTTP ${status}). Intenta de nuevo.`
            : 'No se pudo enviar la solicitud. Revisa los datos e inténtalo de nuevo.'

        // Backend message si existe
        if (data?.message) msg = data.message

        const fieldErrors = status === 422 ? toFieldErrors(data?.errors) : undefined

        serverError.value = msg
        return { ok: false, message: msg, status, fieldErrors }
      }

      serverSuccess.value = data?.message || successMessage
      return { ok: true, message: serverSuccess.value, data }
    } catch (e: any) {
      const aborted = e?.name === 'AbortError'
      const msg = aborted
        ? 'La solicitud tardó demasiado (timeout). Inténtalo de nuevo.'
        : 'Error de conexión. Inténtalo de nuevo.'

      serverError.value = msg
      return { ok: false, message: msg }
    } finally {
      clearTimeout(t)
      loading.value = false
    }
  }

  return { loading, serverError, serverSuccess, resetMessages, submit }
}
