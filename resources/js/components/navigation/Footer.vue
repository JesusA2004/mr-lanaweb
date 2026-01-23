<script setup lang="ts">
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import SocialLinks from '@/components/navigation/SocialLinks.vue'
import iconoWhatsapp from '@/components/ui/HelpWhatsAppCard.vue'
import iconoEmail from '@/components/ui/HelpEmailCard.vue'

type Active = 'servicios' | 'sucursales' | ''
type NavItem = { key: Active; href: string; label: string; icon: string }

const page = usePage()
const year = new Date().getFullYear()

const activeKey = computed<Active>(() => {
  const url = (page.url || '').toLowerCase()
  if (url.startsWith('/sucursales')) return 'sucursales'
  if (url === '/' || url.startsWith('/index')) return 'servicios'
  return ''
})

const isActive = (key: Active, href: string) => {
  const url = (page.url || '').toLowerCase()
  if (key) return key === activeKey.value
  return href !== '/' ? url.startsWith(href) : url === '/'
}

/* Íconos */
const icons = {
  home: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5 12 3l9 7.5"/><path d="M6.5 10v10.5h11V10"/></svg>`,
  card: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/></svg>`,
  rocket: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 19c4-1 8-5 10-9 2-4 1-7 1-7s-3-1-7 1c-4 2-8 6-9 10"/><path d="M9 15l-2 2"/><path d="M14 10l-2 2"/></svg>`,
  sparkles: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l1.2 4.2L17 7.4l-3.8 1.2L12 13l-1.2-4.4L7 7.4l3.8-1.2L12 2z"/><path d="M19 13l.7 2.3 2.3.7-2.3.7L19 19l-.7-2.3-2.3-.7 2.3-.7L19 13z"/></svg>`,
  map: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11z"/><path d="M12 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>`,
  users: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-1a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v1"/><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/><path d="M21 21v-1a4 4 0 0 0-3-3.87"/></svg>`,
  help: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 0 1 5.8 1c0 2-3 2-3 4"/><path d="M12 17h.01"/></svg>`,
  shield: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>`,
  file: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>`,
} as const

const siteLinks = computed<NavItem[]>(() => [
  { key: 'servicios', label: 'Servicios', href: '/', icon: icons.home },
  { key: '', label: 'Crédito.C', href: '/credito-comadres', icon: icons.card },
  { key: '', label: 'Impulsa.N', href: '/impulsa-tu-negocio', icon: icons.rocket },
  { key: '', label: 'Impulsa.T', href: '/impulsat', icon: icons.sparkles },
  { key: 'sucursales', label: 'Sucursales', href: '/sucursales', icon: icons.map },
  { key: '', label: 'Nosotros', href: '/nosotros', icon: icons.users },
  { key: '', label: 'FAQs', href: '/faqs', icon: icons.help },
])

const legalLinks = [
  { label: 'Términos y condiciones', href: '/terminos-y-condiciones', icon: icons.file },
  { label: 'Aviso de privacidad', href: '/aviso-de-privacidad', icon: icons.shield },
  { label: "Preguntas Frecuentes (FAQ's)", href: '/faqs', icon: icons.help },
]

/* UI */
const UI = {
  footer: 'w-full text-slate-900 bg-white',
  // En pantallas grandes, dale más “aire útil” al contenido (menos margen)
  pad: 'px-6 lg:px-10 xl:px-14 2xl:px-16',
  h: 'text-[12px] font-black tracking-[0.24em] uppercase text-slate-700/80',
  pill: (active: boolean) =>
    [
      'group inline-flex w-full items-center gap-3 rounded-2xl px-4 py-3',
      'text-[14px] xl:text-[15px] font-semibold',
      'bg-white/80 ring-1 ring-black/5 shadow',
      'transition',
      'hover:-translate-y-[2px] hover:shadow-md',
      'hover:ring-cyan-400/40 hover:shadow-[0_16px_46px_-30px_rgba(34,211,238,0.55)]',
      'focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60',
      active && 'ring-2 ring-emerald-400/55',
    ]
      .filter(Boolean)
      .join(' '),
  icon: 'h-[18px] w-[18px] opacity-90 transition group-hover:opacity-100',
  underline:
    'underline decoration-transparent underline-offset-4 transition group-hover:decoration-emerald-500/70 dark:group-hover:decoration-emerald-300/80',
  legal:
    'group inline-flex w-full md:w-auto items-center gap-3 rounded-2xl px-3 py-2 text-[14px] font-semibold ' +
    'whitespace-nowrap ' +
    'text-slate-800 hover:text-slate-950 hover:bg-white/65 ring-1 ring-transparent ' +
    'dark:text-white/85 dark:hover:text-white dark:hover:bg-white/10 ' +
    'transition focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60',
  legalU:
    'relative after:absolute after:-bottom-0.5 after:left-0 after:h-[2px] after:w-0 ' +
    'after:bg-gradient-to-r after:from-cyan-500 after:via-emerald-500 after:to-lime-400 ' +
    'after:transition-all after:duration-300 group-hover:after:w-full',
}
</script>

<template>
  <footer :class="UI.footer" role="contentinfo">
    <!-- HEADER -->
    <div class="relative">
      <img
        src="/img/footer/mobile-footer.webp"
        class="block w-full select-none object-cover"
        loading="lazy"
        alt="Mr. Lana"
        draggable="false"
      />
    </div>

    <section :class="[UI.pad, 'py-3']" aria-label="Footer">
      <div class="grid grid-cols-1 gap-10 md:grid-cols-12 md:gap-12">
        <!-- Contacto -->
        <address class="not-italic min-w-0 md:col-span-6 lg:col-span-4 xl:col-span-3">
          <div class="mt-4 space-y-4">
            <iconoWhatsapp title="Contáctanos" phone="5217774225973" label="(777) 422-5973" />
            <iconoEmail title="Correo" email="atencionclientes@mr-lana.com" />
          </div>

          <p class="mt-4 text-sm font-semibold text-slate-800 dark:text-white/85">
            Servicio al cliente:
            <span class="ml-2 text-slate-950 dark:text-white">LUN–SAB: 10:00am a 8:00pm</span>
          </p>
        </address>

        <!-- Sitio (crece en xl/2xl para llenar espacio) -->
        <nav class="min-w-0 md:col-span-6 lg:col-span-8 xl:col-span-9" aria-label="Sitio">
          <div :class="UI.h">Enlaces del sitio</div>

          <!-- En pantallas grandes: más columnas, más “ocupación” -->
          <ul class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4">
            <li v-for="l in siteLinks" :key="l.href">
              <Link :href="l.href" :class="UI.pill(isActive(l.key, l.href))">
                <span :class="UI.icon" v-html="l.icon" aria-hidden="true" />
                <span :class="UI.underline">{{ l.label }}</span>
                <span class="ml-auto opacity-50 transition group-hover:opacity-100" aria-hidden="true">↗</span>
              </Link>
            </li>
          </ul>
        </nav>

        <!-- SOCIAL + LEGAL -->
        <!-- md+ en columna (1 abajo de otro), pero xl/2xl: en la misma fila -->
        <section class="min-w-0 md:col-span-12">
          <div class="grid grid-cols-1 gap-6 xl:grid-cols-12 xl:items-start">
            <!-- Síguenos -->
            <div class="xl:col-span-6 2xl:col-span-6">
              <SocialLinks />
            </div>

            <!-- Legal -->
            <div class="xl:col-span-6 2xl:col-span-6">
              <div class="mt-0" :class="UI.h">Legal</div>

              <!-- Legal: fila con wrap desde md+ -->
              <ul class="mt-3 flex flex-col gap-2 md:flex-row md:flex-wrap md:gap-3">
                <li v-for="l in legalLinks" :key="l.href">
                  <Link :href="l.href" :class="UI.legal">
                    <span class="h-[18px] w-[18px] opacity-90" v-html="l.icon" aria-hidden="true" />
                    <span :class="UI.legalU">{{ l.label }}</span>
                    <span class="ml-auto opacity-50 transition group-hover:opacity-100" aria-hidden="true">↗</span>
                  </Link>
                </li>
              </ul>
            </div>
          </div>
        </section>
      </div>

      <div class="mt-10 border-t border-black/10 pt-4 text-center dark:border-white/10">
        <p class="text-xs font-semibold text-slate-600 dark:text-white/60">
          © {{ year }} Mr. Lana. Todos los derechos reservados.
        </p>
      </div>
    </section>
  </footer>
</template>
