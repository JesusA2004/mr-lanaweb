<script setup lang="ts">
import { onMounted } from 'vue'

/**
 * Chat web de ChatManager (mensajes.mr-lana.com). Los mensajes llegan al
 * departamento configurado en la conexión «Chat web» de ChatManager.
 * El script se inyecta una sola vez: Inertia navega sin recargar la página.
 */
declare global {
  interface Window {
    ChatManager?: ((...args: unknown[]) => void) & { q?: unknown[][] }
  }
}

const SCRIPT_ID = 'chat-manager-widget'
const SCRIPT_URL = 'https://mensajes.mr-lana.com/widget/v1/chat-manager.js'
const WIDGET_KEY = 'xBQEEIYlqOpEoMFPNMAgET5jFV5Q90b1fSUUUvfDj3Kt0Q69'

onMounted(() => {
  if (document.getElementById(SCRIPT_ID)) return

  const w = window
  w.ChatManager =
    w.ChatManager ||
    Object.assign(
      function (...args: unknown[]) {
        ;(w.ChatManager!.q = w.ChatManager!.q || []).push(args)
      },
      { q: [] as unknown[][] }
    )

  const s = document.createElement('script')
  s.id = SCRIPT_ID
  s.async = true
  s.src = SCRIPT_URL
  document.head.appendChild(s)

  w.ChatManager('init', { key: WIDGET_KEY })
})
</script>

<template>
  <!-- No renderiza UI propia: el widget se pinta solo -->
  <span class="hidden" aria-hidden="true"></span>
</template>
