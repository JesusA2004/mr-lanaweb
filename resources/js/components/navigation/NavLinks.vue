<script setup lang="ts">
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

type Active = 'servicios' | 'sucursales' | ''

type NavItem = {
  key: Active
  href: string
  label: string
  mobileLabel?: string
  icon: string
}

const props = withDefaults(
  defineProps<{
    active?: Active
    variant?: 'desktop' | 'mobile'
    onNavigate?: () => void
    class?: string
  }>(),
  { active: '', variant: 'desktop' }
)

const page = usePage()

const activeKey = computed<Active>(() => {
  if (props.active) return props.active
  const url = (page.url || '').toLowerCase()
  if (url.startsWith('/sucursales')) return 'sucursales'
  if (url === '/' || url.startsWith('/index')) return 'servicios'
  return ''
})

/* ================= ICONOS TABLER ================= */
const icons = {
  services: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <path d="M8 7v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" />
    <rect x="3" y="7" width="18" height="14" rx="2" />
  </svg>`,
  branch: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 21s7-4.5 7-11a7 7 0 0 0-14 0c0 6.5 7 11 7 11z"/>
    <circle cx="12" cy="10" r="2"/>
  </svg>`,
  rocket: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <path d="M5 15l4 4"/>
    <path d="M14 5l5 5"/>
    <path d="M9 19c4-1 7-4 9-9"/>
  </svg>`,
  spark: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <rect x="4" y="6" width="16" height="12" rx="2"/>
    <path d="M4 10h16"/>
  </svg>`,
  credit: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="5" width="18" height="14" rx="2"/>
    <path d="M3 10h18"/>
  </svg>`,
  about: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <circle cx="9" cy="8" r="3"/>
    <circle cx="17" cy="8" r="3"/>
    <path d="M2 20c0-3 3-5 7-5"/>
    <path d="M12 20c0-3 3-5 7-5"/>
  </svg>`,
  faq: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 18h.01"/>
    <path d="M9 9a3 3 0 1 1 6 1c0 2-3 2-3 4"/>
    <path d="M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
  </svg>`,
} as const

const links = computed<NavItem[]>(() => [
  { key: 'servicios', label: 'Servicios', mobileLabel: 'Servicios', href: '/', icon: icons.services },
  { key: '', label: 'Crédito.C', mobileLabel: 'Crédito Comadres', href: '/credito-comadres', icon: icons.credit },
  { key: '', label: 'Impulsa.N', mobileLabel: 'Impulsa tu negocio', href: '/impulsa-tu-negocio', icon: icons.rocket },
  { key: '', label: 'Impulsa.t', mobileLabel: 'Impulsa.t', href: '/impulsat', icon: icons.spark },
  { key: 'sucursales', label: 'Sucursales', mobileLabel: 'Sucursales', href: '/sucursales', icon: icons.branch },
  { key: '', label: 'Nosotros', mobileLabel: '¿Quiénes somos?', href: '/nosotros', icon: icons.about },
  { key: '', label: 'FAQs', mobileLabel: 'FAQs', href: '/faqs', icon: icons.faq },
])

const isActive = (key: Active, href: string) => {
  const url = (page.url || '').toLowerCase()
  if (key) return key === activeKey.value
  return url.startsWith(href.toLowerCase())
}

// DESKTOP (más compacto)
const desktopLinkClass = (key: Active, href: string) => {
  const active = isActive(key, href)
  return [
    'group relative inline-flex items-center shrink-0',
    // gaps más tight en md
    'gap-1 sm:gap-1.5 md:gap-1 lg:gap-1',
    // padding mínimo
    'px-0.5 py-1',
    'text-neutral',
    // tamaño más pequeño en md para que QUEPA TODO
    'text-[9px] sm:text-[10px] md:text-[9px] lg:text-[10px]',
    // tracking más chico en md (ahí se te muere el espacio)
    'tracking-[0.14em] sm:tracking-[0.16em] md:tracking-[0.10em] lg:tracking-[0.20em]',
    'font-black uppercase',
    'leading-none',              // evita que el alto “mate” espacio
    'transition-all duration-200',
    'hover:-translate-y-[1px]',
    active ? 'opacity-100' : 'opacity-90 hover:opacity-100',
  ].join(' ')
}

const desktopIconClass = (key: Active, href: string) => {
  const active = isActive(key, href)
  return [
    'inline-flex shrink-0',
    'h-[12px] w-[12px] sm:h-[14px] sm:w-[14px] lg:h-[16px] lg:w-[16px]',
    'transition-all duration-200',
    active ? 'text-emerald-700' : 'text-black/85 group-hover:text-emerald-700',
  ].join(' ')
}

const desktopUnderlineClass = (key: Active, href: string) => {
  const active = isActive(key, href)
  return [
    'absolute left-1/2 -translate-x-1/2',
    'bottom-[-6px] sm:bottom-[-7px] md:bottom-[-6px]',
    'h-[3px] rounded-full',
    'bg-emerald-500 shadow-[0_2px_8px_rgba(16,185,129,0.45)]',
    'transition-all duration-300',
    active ? 'w-full' : 'w-0 group-hover:w-full',
  ].join(' ')
}


/* ===================== MOBILE ===================== */
const mobileItemClass = (key: Active, href: string) => {
  const active = isActive(key, href)
  return [
    'group flex w-full items-center gap-3 rounded-2xl px-3.5 py-3.5',
    'text-[15px] font-semibold transition',
    active ? 'bg-white/10 text-white' : 'text-white/90 hover:bg-white/10',
  ].join(' ')
}

const mobileIconClass = (key: Active, href: string) => {
  const active = isActive(key, href)
  return [
    'grid h-10 w-10 place-items-center rounded-xl ring-1 ring-white/10',
    active ? 'bg-white/15 text-emerald-300' : 'bg-white/10 text-white/90',
  ].join(' ')
}
</script>

<template>
  <!-- DESKTOP -->
    <!-- DESKTOP -->
<nav
  v-if="variant === 'desktop'"
  :class="[
    'relative inline-flex flex-nowrap items-center justify-start',
    'whitespace-nowrap',
    // OJO: aquí NO overflow, el scroll lo hace el wrapper en Navbar.vue
    'gap-x-4 sm:gap-x-5 md:gap-x-4 lg:gap-x-5',
    'rounded-full px-3 py-2 sm:px-4 sm:py-2.5 md:px-4',
    'bg-sky-100 backdrop-blur-md',
    'shadow-[0_10px_30px_rgba(0,0,0,0.08)] border border-white/60',
    props.class ?? ''
  ]"
>
  <Link
    v-for="l in links"
    :key="l.href"
    :href="l.href"
    :class="desktopLinkClass(l.key, l.href)"
  >
    <span :class="desktopIconClass(l.key, l.href)" v-html="l.icon" />
    <span class="relative">
      {{ l.label }}
      <span :class="desktopUnderlineClass(l.key, l.href)" />
    </span>
  </Link>
</nav>

  <!-- MOBILE (drawer list style) -->
  <nav v-else class="space-y-2">
    <Link
      v-for="l in links"
      :key="`m-${l.href}`"
      :href="l.href"
      :class="mobileItemClass(l.key, l.href)"
      @click="onNavigate?.()"
    >
      <span :class="mobileIconClass(l.key, l.href)">
        <span class="h-5 w-5" v-html="l.icon" />
      </span>
      <span class="flex-1">{{ l.mobileLabel ?? l.label }}</span>
    </Link>
  </nav>
</template>
