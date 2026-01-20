<script setup lang="ts">
defineProps<{
  title?: string
  email: string
  label?: string
}>()
</script>

<template>
  <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
    <h4
      class="mb-2 font-bold text-gray-900 dark:text-gray-100
             text-sm sm:text-base md:text-lg lg:text-xl"
    >
      {{ title ?? 'Correo' }}
    </h4>

    <a
      :href="`mailto:${email}`"
      class="group inline-flex items-center gap-2
             font-semibold transition
             text-slate-900 hover:text-red-600
             dark:text-slate-100 dark:hover:text-red-400
             text-sm sm:text-base md:text-lg lg:text-xl"
      rel="noopener noreferrer"
    >
      <!-- Icono correo (sutil) -->
      <svg
        class="w-4 h-4 sm:w-4 sm:h-4 md:w-5 md:h-5
               text-red-500/80 group-hover:text-red-600
               dark:text-red-400/80 dark:group-hover:text-red-400
               transition"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
        aria-hidden="true"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M3 8l9 6 9-6M4 6h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"
        />
      </svg>

      <!-- Texto -->
      <span
        class="break-all underline decoration-transparent underline-offset-4
               transition group-hover:decoration-red-400"
      >
        {{ label ?? email }}
      </span>
    </a>
  </div>
</template>
