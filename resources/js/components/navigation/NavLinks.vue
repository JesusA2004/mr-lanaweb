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

/* ================= ICONOS ================= */
const icons = {
  services: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="3" y="7" width="18" height="14" rx="2"/></svg>`,
  credit: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="3" y="5" width="18" height="14" rx="2"/></svg>`,
  rocket: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M9 19c4-1 7-4 9-9"/></svg>`,
  spark: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="4" y="6" width="16" height="12" rx="2"/></svg>`,
  branch: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 21s7-4.5 7-11"/></svg>`,
  about: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="8" r="3"/></svg>`,
  faq: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 18h.01"/></svg>`
} as const

const links = computed<NavItem[]>(() => [
  { key: 'servicios', label: 'Servicios', href: '/', icon: icons.services },
  { key: '', label: 'Crédito.C', href: '/credito-comadres', icon: icons.credit },
  { key: '', label: 'Impulsa.N', href: '/impulsa-tu-negocio', icon: icons.rocket },
  { key: '', label: 'Impulsa.T', href: '/impulsat', icon: icons.spark },
  { key: 'sucursales', label: 'Sucursales', href: '/sucursales', icon: icons.branch },
  { key: '', label: 'Nosotros', href: '/nosotros', icon: icons.about },
  { key: '', label: 'FAQs', href: '/faqs', icon: icons.faq }
])

const isActive = (key: Active, href: string) => {
  const url = (page.url || '').toLowerCase()
  if (key) return key === activeKey.value
  return href !== '/' ? url.startsWith(href) : url === '/'
}

/* ================= DESKTOP ================= */
const desktopLinkClass = (key: Active, href: string) => {
  const active = isActive(key, href)
  return [
    'group inline-flex items-center gap-1 shrink-0',
    'uppercase font-extrabold',
    'text-[11px] tracking-[0.18em]',
    'text-white',
    'transition hover:text-teal-300',
    active && 'underline underline-offset-8 decoration-emerald-600'
  ].filter(Boolean).join(' ')
}

const desktopIconClass = () =>
  'h-[14px] w-[14px] text-white'
</script>

<template>
  <!-- DESKTOP -->
  <nav
    v-if="variant === 'desktop'"
    class="w-full overflow-x-auto whitespace-nowrap
           [-ms-overflow-style:none] [scrollbar-width:none]"
  >
    <div class="inline-flex items-center gap-6 px-1 [&::-webkit-scrollbar]:hidden">
      <Link
        v-for="l in links"
        :key="l.href"
        :href="l.href"
        :class="desktopLinkClass(l.key, l.href)"
      >
        <span :class="desktopIconClass()" v-html="l.icon" />
        <span>{{ l.label }}</span>
      </Link>
    </div>
  </nav>

  <!-- MOBILE (NO TOCAR, SE QUEDA IGUAL) -->
  <nav v-else class="space-y-2">
    <Link
      v-for="l in links"
      :key="l.href"
      :href="l.href"
      class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white font-semibold"
      @click="onNavigate?.()"
    >
      <span class="h-5 w-5" v-html="l.icon" />
      <span>{{ l.mobileLabel ?? l.label }}</span>
    </Link>
  </nav>
</template>
