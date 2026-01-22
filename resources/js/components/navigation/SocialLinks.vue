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
  item:
    'group inline-flex items-center gap-2 rounded-2xl bg-white/70 px-3 py-2 ' +
    'text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-black/5 backdrop-blur transition ' +
    'hover:-translate-y-0.5 hover:bg-white/90 hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/40 ' +
    'dark:bg-white/5 dark:text-slate-100 dark:ring-white/10 dark:hover:bg-white/10',
  icon: 'h-[18px] w-[18px] opacity-85 transition group-hover:opacity-100',
  underline:
    'underline decoration-transparent underline-offset-4 transition group-hover:decoration-slate-700 dark:group-hover:decoration-white/60',
}
</script>

<template>
  <section aria-label="Redes sociales">
    <h3 :class="UI.title">Síguenos en</h3>

    <ul class="mt-3 flex flex-wrap gap-3">
      <li v-for="l in links" :key="l.name">
        <a :href="l.href" target="_blank" rel="noreferrer" :class="UI.item">
          <img :src="l.icon" :alt="l.name" :class="UI.icon" loading="lazy" />
          <span :class="UI.underline">{{ l.name }}</span>
          <span class="opacity-60 transition group-hover:opacity-100" aria-hidden="true">↗</span>
        </a>
      </li>
    </ul>
  </section>
</template>
