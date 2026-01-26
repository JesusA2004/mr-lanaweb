<script setup lang="ts">
import { computed } from 'vue'

type ToastState = { type: 'success' | 'error' | 'info'; text: string } | null

const props = defineProps<{ toast: ToastState }>()
const isVisible = computed(() => !!props.toast)
</script>

<template>
  <div
    v-if="isVisible"
    class="fixed top-4 right-4 z-[2147483647] w-[min(92vw,420px)]"
  >
    <div
      class="rounded-2xl px-4 py-3 shadow-xl ring-1 backdrop-blur"
      :class="props.toast?.type === 'success'
        ? 'bg-emerald-600 text-white ring-emerald-700/40'
        : props.toast?.type === 'error'
        ? 'bg-rose-600 text-white ring-rose-700/40'
        : 'bg-slate-900 text-white ring-white/10'"
      role="status"
      aria-live="polite"
    >
      <div class="flex items-start gap-3">
        <div class="mt-0.5 font-extrabold">
          {{ props.toast?.type === 'success' ? 'Enviado' : props.toast?.type === 'error' ? 'Error' : 'Info' }}
        </div>
        <div class="text-sm font-semibold opacity-95">
          {{ props.toast?.text }}
        </div>
      </div>
    </div>
  </div>
</template>
