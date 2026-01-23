<script setup lang="ts">
const links = [
  {
    name: 'Facebook',
    href: 'https://www.facebook.com/people/Mr-Lana/61552688275964/',
    icon: '/img/icons/logo-fb.png',
  },
  {
    name: 'Instagram',
    href: 'https://www.instagram.com/mr.lana_mx/',
    icon: '/img/icons/logo-ig.png',
  },
]

const UI = {
  title: 'text-sm font-extrabold tracking-wide text-slate-900 dark:text-slate-100',

  // Item: full width en mobile, auto-width en md+
  item:
    'group inline-flex w-full md:w-auto items-center gap-3 ' +
    'rounded-2xl px-4 py-3 ' +
    'bg-white/70 ring-1 ring-black/5 shadow-sm backdrop-blur ' +
    'transition hover:-translate-y-0.5 hover:bg-white/90 hover:shadow-md ' +
    'focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/40 ' +
    'dark:bg-white/5 dark:ring-white/10 dark:hover:bg-white/10',

  left: 'inline-flex items-center gap-3',
  icon: 'h-[18px] w-[18px] opacity-90 transition group-hover:opacity-100',
  label: 'text-sm font-semibold text-slate-900 dark:text-slate-100',

  // “Abrir” ya no empuja el botón: se vuelve un badge compacto
  ext:
    'ml-auto inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-extrabold ' +
    'text-slate-600/80 ring-1 ring-black/5 bg-white/60 ' +
    'transition group-hover:text-slate-800 group-hover:bg-white/90 ' +
    'dark:text-slate-300/80 dark:bg-white/5 dark:ring-white/10',
}
</script>

<template>
  <section aria-label="Redes sociales">
    <h3 :class="UI.title">Síguenos en</h3>

    <!-- Columna en mobile, fila con wrap en md+ -->
    <ul class="mt-3 flex flex-col gap-3 md:flex-row md:flex-wrap md:items-center">
      <li v-for="l in links" :key="l.name">
        <a :href="l.href" target="_blank" rel="noreferrer" :class="UI.item">
          <span :class="UI.left">
            <img :src="l.icon" :alt="l.name" :class="UI.icon" loading="lazy" />
            <span :class="UI.label">{{ l.name }}</span>
          </span>

          <span :class="UI.ext" aria-hidden="true">Abrir ↗</span>
        </a>
      </li>
    </ul>
  </section>
</template>
