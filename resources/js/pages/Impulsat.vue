<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import MrBannerAppStore from '@/components/home/AppDownloadBanner.vue'
import BusinessLoanRequestModal from '@/components/forms/BusinessLoanRequestModal.vue'
import CtaSection from '@/components/vacancies/CtaSection.vue'
import SegmentTabs, { type SegmentTabItem } from '@/components/ui/SegmentTabs.vue'
import { branches } from '@/data/sucursales'
import { ref, onMounted, computed } from 'vue'
import Swal from 'sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

function handleOpenVacancies() {
  window.dispatchEvent(new CustomEvent('open-vacancies-global'))
}

// ======== helper Swal (rápido, enterprise, sin mamadas) ========
function swalOk(text: string) {
  return Swal.fire({
    icon: 'success',
    title: 'Enviado',
    text,
    confirmButtonText: 'OK',
    heightAuto: false,
  })
}

function swalErr(text: string) {
  return Swal.fire({
    icon: 'error',
    title: 'Error',
    text,
    confirmButtonText: 'Entendido',
    heightAuto: false,
  })
}

function swalLoading(text = 'Enviando...') {
  Swal.fire({
    title: text,
    allowOutsideClick: false,
    allowEscapeKey: false,
    didOpen: () => Swal.showLoading(),
    heightAuto: false,
  })
}

// Datos de los créditos
const creditSpecs = {
  crece12: {
    titulo: 'Crédito Crece12',
    esquema: 'Semanal',
    plazo: '12 pagos (lunes a viernes)',
    montoInicial: 'Sujeto a disponibilidad de pago',
    montoMinimo: '$5,000.00',
    montoMaximo: '$100,000.00',
    poliza: '$100',
    multa: '$12.50 por cada $1000',
    aumento: '$1,000.00 por cada ciclo de acuerdo a política de aumentos',
    costos: 'No aplica',
    cat: '1887.06%',
    icon: '/img/icons/icon-credit-crece12.png',
    alt: 'Crece12',
  },
  crece24: {
    titulo: 'Crédito Crece24',
    esquema: 'Semanal',
    plazo: '24 pagos (lunes a viernes)',
    montoInicial: 'Sujeto a disponibilidad de pago',
    montoMinimo: '$10,000.00',
    montoMaximo: '$100,000.00',
    poliza: '$100',
    multa: '$12.50 por cada $1000',
    aumento: '$1,000.00 por cada ciclo de acuerdo a política de aumentos',
    costos: 'No aplica',
    cat: '1887.06%',
    icon: '/img/icons/icon-credit-crece24.png',
    alt: 'Crece24',
  },
} as const

type CreditKey = keyof typeof creditSpecs

const openModal = ref(false)

function openBusinessModal() {
  openModal.value = true
}

function closeBusinessModal() {
  openModal.value = false
  const url = new URL(window.location.href)
  url.searchParams.delete('solicitar')
  window.history.replaceState({}, '', url.toString())
}

const sending = ref(false)

async function onSubmit(payload: any) {
  if (sending.value) return

  const csrf = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || ''
  sending.value = true

  // Loading visible sí o sí
  swalLoading('Enviando solicitud...')

  try {
    const res = await fetch('/formularios/enviar', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrf,
        Accept: 'application/json',
      },
      body: JSON.stringify(payload),
    })

    if (res.ok) {
      closeBusinessModal()
      Swal.close()
      await swalOk('Listo: tu solicitud fue enviada. En breve te contactamos.')
      return
    }

    const err = await res.json().catch(() => ({}))
    const msg =
      err?.message ||
      (err?.errors ? (Object.values(err.errors).flat() as any[]).join(' ') : '') ||
      'No se pudo enviar. Intenta de nuevo.'

    Swal.close()
    await swalErr(msg)
  } catch (e) {
    Swal.close()
    await swalErr('Sin conexión o servidor no disponible. Intenta en un momento.')
  } finally {
    sending.value = false
  }
}

onMounted(() => {
    // Swal.fire({ icon: 'info', title: 'Swal OK', text: 'Ya está entrando', heightAuto: false })
  const params = new URLSearchParams(window.location.search)
  if (params.get('solicitar') === '1') openBusinessModal()
})

function openWhatsApp() {
  window.open('https://wa.me/5217774225973', '_blank')
}

const activeCredit = ref<CreditKey>('crece12')

const creditTabs = computed<SegmentTabItem[]>(() => [
  { key: 'crece12', label: 'Crece12', iconSrc: creditSpecs.crece12.icon, iconAlt: creditSpecs.crece12.alt },
  { key: 'crece24', label: 'Crece24', iconSrc: creditSpecs.crece24.icon, iconAlt: creditSpecs.crece24.alt },
])

const currentCredit = computed(() => creditSpecs[activeCredit.value])

const steps = [
  { title: '1. Documentación', desc: 'Entrega al gestor de crédito tus documentos', src: '/img/icons/icon-doc.png', alt: 'Documentos' },
  { title: '2. Formato', desc: 'Firma los formatos de crédito Mr. lana.', src: '/img/icons/icon-pencil.png', alt: 'Formato' },
  { title: '3. Acepta la propuesta', desc: 'Grabamos un pequeño video, donde se aprecia tu casa o negocio.', src: '/img/icons/icon-video.png', alt: 'Video' },
  { title: '4. Evaluación', desc: 'En 15 minutos te notificamos si tu crédito ha sido autorizado.', src: '/img/icons/icon-time.png', alt: 'Evaluación' },
  { title: '5. Desembolso', desc: 'Espera la transferencia a tu cuenta por desembolso y comienza a impulsar tus proyectos.', src: '/img/icons/icon-money.png', alt: 'Desembolso' },
]
</script>

<template>
  <Head title="Impulsa.t" />
  <PublicLayout>
    <BusinessLoanRequestModal
      :open="openModal"
      :branches="branches"
      context="impulsat"
      :sending="sending"
      @close="closeBusinessModal"
      @submit="onSubmit"
    />

    <!-- Banner Superior -->
    <div class="relative w-full overflow-hidden">
      <picture class="block w-full">
        <source media="(min-width: 768px)" srcset="/img/impulsat-banner.jpg" />
        <img src="/img/bg-impulsat-mobile.jpg" alt="Banner negocio" class="block w-full h-auto object-contain" draggable="false" />
      </picture>

      <div class="absolute inset-0 hidden md:block bg-gradient-to-b from-black/55 via-black/30 to-black/55" />

      <div class="absolute inset-0 z-10 flex items-end justify-center">
        <div class="w-full px-4 pb-5 sm:pb-6 md:pb-7">
          <div class="mx-auto max-w-[760px] text-center pointer-events-auto">
            <button
              type="button"
              @click="openBusinessModal"
              class="inline-flex items-center justify-center
                rounded-full bg-black/70 px-6
                sm:w-[180px] md:w-[230px] lg:w-[300px] xl:w-[340px]
                2xl:w-[400px] py-2 sm:py-2 md:py-5 lg:py-6 xl:py-7 2xl:py-8
                text-base sm:text-lg md:text-2xl lg:text-3xl xl:text-4xl 2xl:text-5xl font-extrabold text-white
                shadow-lg ring-1 ring-white/15 transition
                hover:bg-black/80 hover:scale-[1.01] active:scale-[0.99]"
            >
              Solicitar ahora
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Pasos -->
    <section class="bg-white px-4 py-10 sm:py-12 md:py-14 lg:py-16 overflow-hidden">
      <div class="mx-auto max-w-7xl">
        <header class="text-center mb-9 sm:mb-10 md:mb-12">
          <h2 class="text-black uppercase tracking-tight font-extrabold text-2xl sm:text-3xl md:text-4xl lg:text-5xl">
            PASOS PARA OBTENER TU CRÉDITO
          </h2>
        </header>

        <div class="grid gap-4 sm:gap-5 md:gap-6" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
          <article
            v-for="(s, i) in steps"
            :key="`${i}-${s.title}`"
            class="group relative rounded-2xl bg-teal-300/5 ring-teal-300/5 ring-1 p-5 sm:p-6
              shadow-[0_20px_60px_-45px_rgba(0,0,0,0.9)]
              transition duration-300 hover:-translate-y-1 hover:bg-white/[0.08] hover:ring-emerald-400/30"
          >
            <div
              class="pointer-events-none absolute inset-0 rounded-2xl opacity-0 transition duration-300 group-hover:opacity-100"
              style="background: radial-gradient(520px circle at 20% 0%, rgba(16,185,129,.18), transparent 55%);"
            />
            <div class="relative flex items-start gap-4">
              <div class="shrink-0 grid place-items-center rounded-2xl h-12 w-12 bg-black/10 ring-1 ring-black/10 transition duration-300 group-hover:bg-emerald-400/10 group-hover:ring-emerald-400/30">
                <img :src="s.src" :alt="s.alt" class="h-7 w-7 opacity-95" />
              </div>
              <div class="min-w-0">
                <h3 class="text-black font-extrabold leading-snug text-base sm:text-lg">
                  {{ s.title }}
                </h3>
                <p class="mt-2 text-black/75 leading-relaxed text-sm sm:text-base">
                  {{ s.desc }}
                </p>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Créditos -->
    <div class="py-16 px-4 bg-gray-50">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            <span class="block">PRODUCTO CRECE</span>
          </h2>
          <p class="text-xl text-gray-700">
            Conoce el nuevo crédito semanal para cumplir tu sueños, <span class="font-bold">fácil y rápido</span>
          </p>
        </div>

        <div class="rounded-2xl bg-white p-5 sm:p-7 md:p-8 shadow-lg ring-1 ring-gray-200">
          <SegmentTabs v-model="activeCredit" :items="creditTabs" aria-label="Créditos Impulsa.t">
            <template #default>
              <div class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-6 lg:gap-8 items-start">
                <div class="flex items-center justify-center lg:justify-start">
                  <img :src="currentCredit.icon" :alt="currentCredit.alt" class="h-50 w-50 sm:h-36 sm:w-36 md:h-40 md:w-40 lg:h-44 lg:w-44" />
                </div>

                <div>
                  <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                    {{ currentCredit.titulo }}
                  </h3>

                  <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Esquema</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.esquema }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Plazo</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.plazo }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Monto inicial</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.montoInicial }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Monto mínimo</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.montoMinimo }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Monto máximo</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.montoMaximo }}</p>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">CAT</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.cat }}</p>
                    </div>

                    <div class="sm:col-span-2">
                      <p class="text-slate-500 text-sm mb-2">Condiciones</p>

                      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                          <p class="text-xs font-semibold text-slate-500">Póliza</p>
                          <p class="mt-1 font-bold text-slate-900">{{ currentCredit.poliza }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                          <p class="text-xs font-semibold text-slate-500">Multa</p>
                          <p class="mt-1 font-bold text-slate-900">{{ currentCredit.multa }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                          <p class="text-xs font-semibold text-slate-500">Aumento</p>
                          <p class="mt-1 font-bold text-slate-900">{{ currentCredit.aumento }}</p>
                        </div>
                      </div>
                    </div>

                    <div class="sm:col-span-2 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Costos</p>
                      <p class="font-semibold text-slate-900">{{ currentCredit.costos }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </SegmentTabs>
        </div>

        <div class="text-center mt-12">
          <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
            ¿Ya sabes cuál te conviene?
          </h3>
          <button
            type="button"
            @click="openWhatsApp"
            class="px-8 py-4 bg-gradient-to-r from-green-500 to-blue-500 text-white font-bold text-xl rounded-full
              hover:opacity-90 transition flex items-center justify-center mx-auto gap-3"
          >
            <span>Solicita tu préstamo</span>
            <img src="/img/icons/whats-icon.svg" alt="WhatsApp" class="w-6 h-6" />
          </button>
        </div>
      </div>
    </div>

    <section class="py-8 px-4">
      <MrBannerAppStore />
    </section>

    <div class="relative">
      <CtaSection
        :sources="{
          base: '/img/bg-work-mobile.jpg',
          sm: '/img/bg-work-mobile.jpg',
          md: '/img/bg-work-mobile.jpg',
          lg: '/img/banner-employees.jpg',
          xl: '/img/banner-employees.jpg',
          '2xl': '/img/banner-employees.jpg',
        }"
        alt="Bolsa de trabajo"
        button-text="Consulta nuestra bolsa de trabajo"
        @click="handleOpenVacancies()"
        :button-class="'min-w-[180px] lg:min-w-[280px] lg:px-12 lg:py-6 xl:px-16 xl:py-8 lg:text-xl xl:text-2xl'"
      />
    </div>

    <br />
    <br />
  </PublicLayout>
</template>
