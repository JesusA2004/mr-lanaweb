<script setup lang="ts">
defineProps<{
  title?: string
  email: string
  label?: string
}>()

const UI = {
  title: 'text-sm font-extrabold tracking-wide text-slate-900 dark:text-slate-100',
  row: 'inline-flex items-center gap-2 text-sm font-semibold text-slate-900 dark:text-slate-100',
  icon: 'h-[18px] w-[18px]',
  link: 'transition hover:text-rose-600 dark:hover:text-rose-400',
  underline:
    'underline decoration-transparent underline-offset-4 transition group-hover:decoration-rose-400',
}
</script>

<template>
  <section aria-label="Correo">
    <h3 class="mb-2" :class="UI.title">{{ title ?? 'Correo' }}</h3>

    <a
      :href="`mailto:${email}`"
      class="group"
      :class="[UI.row, UI.link]"
      rel="noopener noreferrer"
    >
      <svg
        :class="[
          UI.icon,
          'text-rose-500/90 dark:text-rose-400/90 transition group-hover:text-rose-600 dark:group-hover:text-rose-400',
        ]"
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

      <span class="break-all" :class="UI.underline">{{ label ?? email }}</span>
      <span class="ml-1 opacity-60 transition group-hover:opacity-100" aria-hidden="true">↗</span>
    </a>
  </section>
</template>
