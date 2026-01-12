// resources/js/composables/useVacancySubmit.ts
import { ref } from 'vue'

type SubmitResult = { ok: true } | { ok: false; message: string }

export function useVacancySubmit() {
  const loading = ref(false)
  const serverError = ref<string>('')   // mensaje bonito para FormAlert
  const serverSuccess = ref<string>('') // opcional

  function resetMessages() {
    serverError.value = ''
    serverSuccess.value = ''
  }

  async function submit(url: string, payload: Record<string, any>): Promise<SubmitResult> {
    loading.value = true
    resetMessages()

    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(payload),
      })

      if (!res.ok) {
        // intenta leer json con mensaje
        let msg = 'No se pudo enviar la solicitud. Revisa los datos e inténtalo de nuevo.'
        try {
          const data = await res.json()
          msg = data?.message ?? msg
        } catch {}
        serverError.value = msg
        return { ok: false, message: msg }
      }

      serverSuccess.value = 'Listo: solicitud enviada correctamente.'
      return { ok: true }
    } catch (e) {
      const msg = 'Error de conexión. Inténtalo de nuevo.'
      serverError.value = msg
      return { ok: false, message: msg }
    } finally {
      loading.value = false
    }
  }

  return { loading, serverError, serverSuccess, resetMessages, submit }
}
