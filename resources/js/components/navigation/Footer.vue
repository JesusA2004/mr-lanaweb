<script setup lang="ts">
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

import SocialLinks from '@/components/navigation/SocialLinks.vue'
import iconoWhatsapp from '@/components/ui/HelpWhatsAppCard.vue'
import iconoEmail from '@/components/ui/HelpEmailCard.vue'

type Active = 'servicios' | 'sucursales' | ''

type NavItem = {
  key: Active
  href: string
  label: string
  icon: string
}

const page = usePage()
const year = new Date().getFullYear()

const activeKey = computed<Active>(() => {
  const url = (page.url || '').toLowerCase()
  if (url.startsWith('/sucursales')) return 'sucursales'
  if (url === '/' || url.startsWith('/index')) return 'servicios'
  return ''
})

const icons = {
  services: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="3" y="7" width="18" height="14" rx="2"/></svg>`,
  credit: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="3" y="5" width="18" height="14" rx="2"/></svg>`,
  rocket: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M9 19c4-1 7-4 9-9"/></svg>`,
  spark: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="4" y="6" width="16" height="12" rx="2"/></svg>`,
  branch: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 21s7-4.5 7-11"/></svg>`,
  about: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="8" r="3"/></svg>`,
  faq: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 18h.01"/></svg>`,
} as const

const siteLinks = computed<NavItem[]>(() => [
  { key: 'servicios', label: 'Servicios', href: '/', icon: icons.services },
  { key: '', label: 'Crédito.C', href: '/credito-comadres', icon: icons.credit },
  { key: '', label: 'Impulsa.N', href: '/impulsa-tu-negocio', icon: icons.rocket },
  { key: '', label: 'Impulsa.T', href: '/impulsat', icon: icons.spark },
  { key: 'sucursales', label: 'Sucursales', href: '/sucursales', icon: icons.branch },
  { key: '', label: 'Nosotros', href: '/nosotros', icon: icons.about },
  { key: '', label: 'FAQs', href: '/faqs', icon: icons.faq },
])

const isActive = (key: Active, href: string) => {
  const url = (page.url || '').toLowerCase()
  if (key) return key === activeKey.value
  return href !== '/' ? url.startsWith(href) : url === '/'
}

const legalLinks = [
  { label: 'Términos y condiciones', href: '/terminos-y-condiciones' },
  { label: 'Aviso de privacidad', href: '/aviso-de-privacidad' },
  { label: "Preguntas Frecuentes (FAQ's)", href: '/faqs' },
]

// UI: tamaños fijos, responsive solo para layout
const UI = {
  footer:
    'w-full bg-[#d9d9d9] text-slate-900 dark:bg-[#0b1220] dark:text-slate-100 ' +
    'bg-[radial-gradient(60rem_60rem_at_20%_-10%,rgba(16,185,129,0.18),transparent_60%),radial-gradient(60rem_60rem_at_90%_120%,rgba(56,189,248,0.18),transparent_60%)]',
  pad: 'px-6 lg:px-10',
  title: 'text-sm font-extrabold tracking-wide',
  text: 'text-sm font-semibold',
  // Links del footer (estilo consistente + activo)
  navLink: (active: boolean) =>
    [
      'group inline-flex items-center gap-2 rounded-2xl px-3 py-2',
      'text-sm font-semibold',
      'transition',
      'bg-white/60 hover:bg-white/85 ring-1 ring-black/5 shadow-sm',
      'dark:bg-white/5 dark:hover:bg-white/10 dark:ring-white/10',
      active && 'ring-2 ring-emerald-500/50 dark:ring-emerald-400/40',
    ]
      .filter(Boolean)
      .join(' '),
  navIcon: 'h-[18px] w-[18px] opacity-85 transition group-hover:opacity-100',
  underline:
    'underline decoration-transparent underline-offset-4 transition group-hover:decoration-emerald-500/70',
  legal:
    'group inline-flex items-center gap-2 text-sm font-semibold text-slate-900 transition hover:text-emerald-700 ' +
    'focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/40 ' +
    'dark:text-slate-100 dark:hover:text-emerald-300',
  legalUnderline:
    'relative after:absolute after:-bottom-0.5 after:left-0 after:h-[2px] after:w-0 ' +
    'after:bg-gradient-to-r after:from-emerald-500 after:to-teal-400 ' +
    'after:transition-all after:duration-300 group-hover:after:w-full',
}
</script>

<template>
  <footer :class="UI.footer" role="contentinfo">
    <!-- TOP: logo/hero (sin wrappers innecesarios) -->
    <img
      src="/img/footer/mobile-footer.webp"
      class="block w-full select-none object-cover"
      loading="lazy"
      alt="Mr. Lana"
    />

    <!-- MAIN: full width, sin max-w (adiós franjas) -->
    <section :class="[UI.pad, 'py-10']" aria-label="Footer principal">
      <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
        <!-- CONTACTO: semántico con address -->
        <address class="not-italic lg:col-span-4">
          <h2 :class="UI.title">Contacto</h2>

          <div class="mt-4 space-y-4">
            <iconoWhatsapp title="Contáctanos" phone="5217774225973" label="(777) 422-5973" />
            <iconoEmail title="Correo" email="atencionclientes@mr-lana.com" />
          </div>

          <p class="mt-4" :class="UI.text">
            <span class="font-extrabold tracking-wide">Servicio al cliente:</span>
            <span class="ml-2">LUN–SAB: 10:00am a 8:00pm</span>
          </p>
        </address>

        <!-- NAVEGACIÓN DEL SITIO (tus links del navbar) -->
        <nav class="lg:col-span-5" aria-label="Navegación del sitio">
          <h2 :class="UI.title">Sitio</h2>

          <ul class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
            <li v-for="l in siteLinks" :key="l.href">
              <Link :href="l.href" :class="UI.navLink(isActive(l.key, l.href))">
                <span :class="UI.navIcon" v-html="l.icon" aria-hidden="true" />
                <span :class="UI.underline">{{ l.label }}</span>
              </Link>
            </li>
          </ul>
        </nav>

        <!-- SOCIAL + LEGAL -->
        <section class="lg:col-span-3">
          <SocialLinks />

          <h2 class="mt-8" :class="UI.title">Legal</h2>
          <ul class="mt-4 space-y-3">
            <li v-for="l in legalLinks" :key="l.href">
              <Link :href="l.href" :class="UI.legal">
                <span :class="UI.legalUnderline">{{ l.label }}</span>
                <span class="opacity-60 transition group-hover:opacity-100" aria-hidden="true">↗</span>
              </Link>
            </li>
          </ul>

          <p class="mt-8 text-sm font-semibold text-slate-800 dark:text-slate-200">
            <span class="font-extrabold tracking-wide text-slate-900 dark:text-slate-100">Seguimiento claro:</span>
            Comunicación directa y soporte en horarios establecidos.
          </p>
        </section>
      </div>
    </section>

    <!-- BOTTOM BAR -->
    <section :class="[UI.pad, 'border-t border-black/10 dark:border-white/10 py-4']" aria-label="Créditos">
      <p class="text-center text-xs font-semibold text-slate-700 dark:text-slate-300">
        © {{ year }} Mr. Lana. Todos los derechos reservados.
      </p>
    </section>
  </footer>
</template>
