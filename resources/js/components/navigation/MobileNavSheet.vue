<script setup lang="ts">
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

import {
  Sheet,
  SheetContent,
  SheetHeader,
  SheetTitle,
  SheetTrigger,
  SheetClose,
} from '@/components/ui/sheet'

import Logo from '@/components/ui/Logo.vue'

type Active = 'servicios' | 'sucursales' | ''

const props = defineProps<{ active?: Active }>()
const page = usePage()

const activeKey = computed<Active>(() => {
  if (props.active) return props.active
  const url = (page.url || '').toLowerCase()
  if (url.startsWith('/sucursales')) return 'sucursales'
  if (url === '/' || url.startsWith('/index')) return 'servicios'
  return ''
})

/* ============ MISMO SET DE ICONOS (sin archivos extra) ============ */
const icons = {
  services: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <path d="M8 7v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" />
    <rect x="3" y="7" width="18" height="14" rx="2" />
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
  branch: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 21s7-4.5 7-11a7 7 0 0 0-14 0c0 6.5 7 11 7 11z"/>
    <circle cx="12" cy="10" r="2"/>
  </svg>`,
  faq: `
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
    class="h-full w-full" fill="none" stroke="currentColor"
    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
    <path d="M12 18h.01"/>
    <path d="M9 9a3 3 0 1 1 6 1c0 2-3 2-3 4"/>
    <path d="M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/>
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
} as const

const menu = computed(() => [
  { key: 'servicios' as Active, label: 'Servicios', href: '/', icon: icons.services },
  { key: '' as Active, label: 'Crédito Comadres', href: '/credito-comadres', icon: icons.credit },
  { key: '' as Active, label: 'Impulsa tu negocio', href: '/impulsa-tu-negocio', icon: icons.rocket },
  { key: '' as Active, label: 'Impulsa.t', href: '/impulsat', icon: icons.spark },
  { key: 'sucursales' as Active, label: 'Sucursales', href: '/sucursales', icon: icons.branch },
  { key: '' as Active, label: '¿Quiénes somos?', href: '/nosotros', icon: icons.about },
  { key: '' as Active, label: 'FAQs', href: '/faqs', icon: icons.faq },
])

const isActive = (key: Active, href: string) => {
  const url = (page.url || '').toLowerCase()
  if (key) return key === activeKey.value
  return url.startsWith(href.toLowerCase())
}
</script>

<template>
  <Sheet>
    <SheetTrigger as-child>
      <button
        type="button"
        aria-label="Abrir menú"
        class="group relative inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/75 shadow-sm backdrop-blur transition hover:bg-white/90"
      >
        <span class="absolute h-0.5 w-5 rounded bg-black/90 -translate-y-2"></span>
        <span class="absolute h-0.5 w-5 rounded bg-black/90"></span>
        <span class="absolute h-0.5 w-5 rounded bg-black/90 translate-y-2"></span>
      </button>
    </SheetTrigger>

    <SheetContent side="left" class="p-0 [&>button]:hidden">
      <div class="h-full bg-zinc-950">
        <div class="p-5">
          <SheetHeader class="space-y-4">
            <div class="flex items-center justify-between">
              <Logo />

              <SheetClose as-child>
                <button
                  class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white shadow-sm transition hover:bg-white/15"
                  aria-label="Cerrar"
                >
                  ✕
                </button>
              </SheetClose>
            </div>

            <SheetTitle class="text-white text-lg font-extrabold">
              Bienvenido
            </SheetTitle>
          </SheetHeader>

          <div class="mt-6 space-y-2">
            <SheetClose v-for="it in menu" :key="it.href" as-child>
              <Link
                :href="it.href"
                class="flex items-center gap-3 rounded-2xl px-3.5 py-3.5 text-white/90 transition hover:bg-white/10"
              >
                <span
                  class="grid h-10 w-10 place-items-center rounded-xl bg-white/10 ring-1 ring-white/10"
                  :class="isActive(it.key, it.href) ? 'bg-white/15 text-emerald-300' : 'text-white/90'"
                >
                  <span class="h-5 w-5" v-html="it.icon" />
                </span>
                <span class="text-[15px] font-semibold">{{ it.label }}</span>
              </Link>
            </SheetClose>
          </div>
        </div>
      </div>
    </SheetContent>
  </Sheet>
</template>
