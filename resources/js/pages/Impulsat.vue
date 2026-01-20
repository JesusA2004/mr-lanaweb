<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import Container from '@/components/ui/Container.vue'
import MrBannerAppStore from '@/components/home/AppDownloadBanner.vue'
import BusinessLoanRequestModal from '@/components/forms/BusinessLoanRequestModal.vue'
import SegmentTabs, { type SegmentTabItem } from '@/components/ui/SegmentTabs.vue'
import { branches } from '@/data/sucursales'
import { ref, onMounted, computed } from 'vue'

// Estados para los modales de créditos (se dejan por si luego los conectas)
const showModalCrece12 = ref(false)
const showModalCrece24 = ref(false)
const showModalCrece8q = ref(false)
const showModalCrece12q = ref(false)

function handleOpenVacancies() {
  window.dispatchEvent(new CustomEvent('open-vacancies-global'))
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
  crece8q: {
    titulo: 'Crédito Crece8q',
    esquema: 'Quincenal',
    plazo: '8 pagos (lunes a viernes)',
    montoInicial: 'Sujeto a disponibilidad de pago',
    montoMinimo: '$10,000.00',
    montoMaximo: '$100,000.00',
    poliza: '$130.00 del monto otorgado (monto menor a $10,000) / 1.3% del monto otorgado (monto mayor a $10,000)',
    multa: '10% del monto de pago',
    aumento: 'Hasta un 25% del monto de pago del ciclo anterior',
    costos: 'Comisión apertura 5% / Comisión aumento 5%',
    cat: '1887.06%',
    icon: '/img/icons/icon-credit-crece8q.png',
    alt: 'Crece8q',
  },
  crece12q: {
    titulo: 'Crédito Crece12q',
    esquema: 'Quincenal',
    plazo: '12 pagos (lunes a viernes)',
    montoInicial: 'Sujeto a disponibilidad de pago',
    montoMinimo: '$10,000.00',
    montoMaximo: '$100,000.00',
    poliza: '$130.00 del monto otorgado (monto menor a $10,000) / 1.3% del monto otorgado (monto mayor a $10,000)',
    multa: '10% del monto de pago',
    aumento: 'Hasta un 25% del monto de pago del ciclo anterior',
    costos: 'Comisión apertura 5% / Comisión aumento 5%',
    cat: '1887.06%',
    icon: '/img/icons/icon-credit-crece12q.png',
    alt: 'Crece12q',
  },
} as const

type CreditKey = keyof typeof creditSpecs

/* =========================================================
  Modal BusinessLoanRequestModal + query param
  ========================================================= */
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

function onSubmit(payload: any) {
  console.log('submit impulsat', payload)
  closeBusinessModal()
}

onMounted(() => {
  const params = new URLSearchParams(window.location.search)
  if (params.get('solicitar') === '1') {
    openBusinessModal()
  }
})
/* ========================================================= */

function openWhatsApp() {
  window.open('https://wa.me/5217774225973', '_blank')
}

/* =========================================================
  Tabs en un solo recuadro
  ========================================================= */
const activeCredit = ref<CreditKey>('crece12')

const creditTabs = computed<SegmentTabItem[]>(() => [
  { key: 'crece12', label: 'Crece12', iconSrc: creditSpecs.crece12.icon, iconAlt: creditSpecs.crece12.alt },
  { key: 'crece24', label: 'Crece24', iconSrc: creditSpecs.crece24.icon, iconAlt: creditSpecs.crece24.alt },
  { key: 'crece8q', label: 'Crece8q', iconSrc: creditSpecs.crece8q.icon, iconAlt: creditSpecs.crece8q.alt },
  { key: 'crece12q', label: 'Crece12q', iconSrc: creditSpecs.crece12q.icon, iconAlt: creditSpecs.crece12q.alt },
])

const currentCredit = computed(() => creditSpecs[activeCredit.value])
</script>

<template>
  <Head title="Impulsa.t | Mr Lana" />
  <PublicLayout>
    <!-- MODAL -->
    <BusinessLoanRequestModal
      :open="openModal"
      :branches="branches"
      context="impulsat"
      @close="closeBusinessModal"
      @submit="onSubmit"
    />

    <!-- Banner Superior (RESPONSIVE COMO TU REFERENCIA: h-auto + max-h, sin recorte agresivo) -->
    <div class="relative w-full overflow-hidden">
      <!-- Desktop -->
      <img
        src="/img/impulsat-banner.jpg"
        class="hidden md:block w-full h-auto max-h-[500px] object-cover object-center"
        alt="Banner negocio desktop"
      />
      <!-- Mobile -->
      <img
        src="/img/bg-impulsat-mobile.jpg"
        class="block md:hidden w-full h-auto max-h-[400px] object-cover object-center"
        alt="Banner negocio mobile"
      />

      <!-- TEXTO: no debe capturar clicks -->
      <div class="pointer-events-none absolute inset-0 flex items-center justify-center">
        <div class="text-center text-white">
          <h1 class="text-4xl md:text-6xl font-bold [text-shadow:_0_2px_8px_rgb(0_0_0_/_90%)]">El IMPULSO</h1>
          <p class="text-2xl md:text-4xl font-bold [text-shadow:_0_2px_8px_rgb(0_0_0_/_90%)]">que te FALTABA</p>
        </div>
      </div>

      <!-- CTA: arriba de todo y con clicks habilitados -->
      <div class="absolute inset-0 z-10 flex items-end justify-center">
        <div class="w-full px-4 pb-5 sm:pb-6 md:pb-7">
          <div class="mx-auto max-w-[760px] text-center pointer-events-auto">
            <button
              type="button"
              @click="openBusinessModal"
              class="inline-flex w-full sm:w-auto items-center justify-center
                     rounded-full bg-black/70 px-6 sm:px-10 py-3 sm:py-4
                     text-base sm:text-lg md:text-xl font-extrabold text-white
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
    <div class="bg-gray-900 py-8 px-4 overflow-hidden">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-4xl font-bold text-white uppercase">
            PASOS PARA OBTENER TU CRÉDITO
          </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
          <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
            <div class="mb-4">
              <img src="/img/icons/icon-doc.png" alt="Documentos" class="w-16 h-16 mx-auto">
            </div>
            <h3 class="text-xl font-bold text-white mb-2">1. Documentación</h3>
            <p class="text-gray-300">Entrega al gestor de crédito tus documentos</p>
          </div>

          <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
            <div class="mb-4">
              <img src="/img/icons/icon-pencil.png" alt="Lápiz" class="w-16 h-16 mx-auto">
            </div>
            <h3 class="text-xl font-bold text-white mb-2">2. Formato</h3>
            <p class="text-gray-300">Firma los formatos de crédito Mr. lana.</p>
          </div>

          <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
            <div class="mb-4">
              <img src="/img/icons/icon-video.png" alt="Video" class="w-16 h-16 mx-auto">
            </div>
            <h3 class="text-xl font-bold text-white mb-2">3. Acepta la propuesta</h3>
            <p class="text-gray-300">Grabamos un pequeño video, donde se aprecia tu casa o negocio.</p>
          </div>

          <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
            <div class="mb-4">
              <img src="/img/icons/icon-time.png" alt="Tiempo" class="w-16 h-16 mx-auto">
            </div>
            <h3 class="text-xl font-bold text-white mb-2">4. Evaluación</h3>
            <p class="text-gray-300">En 15 minutos te notificamos si tu crédito ha sido autorizado</p>
          </div>

          <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
            <div class="mb-4">
              <img src="/img/icons/icon-money.png" alt="Dinero" class="w-16 h-16 mx-auto">
            </div>
            <h3 class="text-xl font-bold text-white mb-2">5. Desembolso</h3>
            <p class="text-gray-300">
              Espera la transferencia de pago a tu cuenta por concepto de desembolso de crédito por parte de Mr Lana y comienza a impulsar tus proyectos
            </p>
          </div>
        </div>
      </div>
    </div>

    <br>

    <!-- Quiénes somos -->
    <div class="relative w-full bg-white">
      <div class="px-4 sm:px-6 md:px-8 lg:px-10 xl:px-12 2xl:px-16">
        <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl md:rounded-4xl">
          <div class="absolute inset-0 bg-[url('/img/home/banner-gradient.png')] bg-cover bg-center" />
          <div class="relative z-10 py-12 sm:py-16 md:py-20 lg:py-24 xl:py-28">
            <Container>
              <div class="max-w-6xl mx-auto px-4 sm:px-6 md:px-8 lg:px-10 xl:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 lg:gap-10 xl:gap-12 items-center">
                  <div class="text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white">
                      ¿QUIÉNES SOMOS?
                    </h2>
                  </div>

                  <div>
                    <p class="text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl text-white">
                      Somos una entidad financiera mexicana de nano y microcréditos que trabaja con compromiso y pasión para ofrecer préstamos rápidos de manera
                      sencilla, con el fin de impulsar el crecimiento y desarrollo de particulares y proyectos productivos en el país.
                    </p>
                  </div>
                </div>
              </div>
            </Container>
          </div>
        </div>
      </div>
    </div>

    <!-- Créditos (UN SOLO RECUADRO + Tabs) -->
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
                    <!-- 1) Esquema -->
                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Esquema</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.esquema }}</p>
                    </div>

                    <!-- 2) Plazo -->
                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Plazo</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.plazo }}</p>
                    </div>

                    <!-- 3) Monto inicial -->
                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Monto inicial</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.montoInicial }}</p>
                    </div>

                    <!-- 4) Monto mínimo -->
                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Monto mínimo</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.montoMinimo }}</p>
                    </div>

                    <!-- 5) Monto máximo -->
                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">Monto máximo</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.montoMaximo }}</p>
                    </div>

                    <!-- 6) CAT -->
                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                      <p class="text-slate-500 text-sm">CAT</p>
                      <p class="font-bold text-slate-900">{{ currentCredit.cat }}</p>
                    </div>

                    <!-- Póliza / Multa / Aumento (separado y claro) -->
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

                    <!-- Costos -->
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

        <!-- WhatsApp -->
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
            <img src="/img/icons/whats-icon.svg" alt="WhatsApp" class="w-6 h-6">
          </button>
        </div>
      </div>
    </div>

    <!-- App Store -->
    <section class="py-8 px-4">
      <MrBannerAppStore />
    </section>

    <!-- Vacantes -->
    <div class="relative">
      <div
        class="block md:hidden py-20 md:py-28 bg-cover bg-center"
        :style="{ backgroundImage: 'url(/img/bg-work-mobile.jpg)' }"
      >
        <Container>
          <div class="flex flex-col items-center justify-center text-center">
            <button
              @click="handleOpenVacancies()"
              class="bg-white text-green-600 hover:bg-green-50 px-6 py-3 text-base font-bold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
              style="min-width: 220px;"
            >
              Bolsa de trabajo
            </button>
          </div>
        </Container>
      </div>

      <div
        class="hidden md:block py-28 lg:py-32 xl:py-40 bg-cover bg-center"
        :style="{ backgroundImage: 'url(/img/banner-employees.jpg)' }"
      >
        <Container>
          <div class="flex flex-col items-center justify-center text-center">
            <button
              @click="handleOpenVacancies()"
              class="bg-white text-green-600 hover:bg-green-50 px-8 py-4 lg:px-12 lg:py-6 xl:px-16 xl:py-8 text-lg lg:text-xl xl:text-2xl font-bold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
              style="min-width: 280px;"
            >
              Bolsa de trabajo
            </button>
          </div>
        </Container>
      </div>
    </div>

    <br>
  </PublicLayout>
</template>

<style scoped>
.banner-employees {
  background-image: url('/img/bg-employees.jpg');
  background-size: cover;
  background-position: center;
}
</style>
