<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import { computed, onMounted, ref } from 'vue'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import CtaSection from '@/components/vacancies/CtaSection.vue'
    import BannerAppStore from '@/components/home/AppDownloadBanner.vue'
    import BusinessLoanRequestModal from '@/components/forms/BusinessLoanRequestModal.vue'
    import SegmentTabs, { type SegmentTabItem } from '@/components/ui/SegmentTabs.vue'
    import { branches } from '@/data/sucursales'
    import { credits } from '@/data/credits'

    function handleOpenVacancies() {
        window.dispatchEvent(new CustomEvent('open-vacancies-global'))
    }

    const steps = [
        { stepTitle: '1. Documentación', stepSubtitle: 'Entregar al gestor de crédito tus documentos', src: '/img/icons/icon-doc.png', alt: 'documentos' },
        { stepTitle: '2. Formato', stepSubtitle: 'Llena los formatos de crédito Mr. lana.', src: '/img/icons/icon-pencil.png', alt: 'lapiz' },
        { stepTitle: '3. Acepta la propuesta', stepSubtitle: 'Grabamos un pequeño video solicitando tu crédito, donde se aprecia tu negocio.', src: '/img/icons/icon-video.png', alt: 'video' },
        { stepTitle: '4. Evaluación de tu video.', stepSubtitle: 'En 15 minutos te notificamos si tu crédito ha sido autorizado o rechazado.', src: '/img/icons/icon-time.png', alt: 'tiempo' },
        { stepTitle: '5. Gestor de crédito', stepSubtitle: 'Realizaremos una grabación de desembolso de crédito.', src: '/img/icons/icon-money.png', alt: 'dinero' },
        { stepTitle: '6. Recibe tu dinero.', stepSubtitle: 'Disfruta e invierte tu crédito y haz crecer tu negocio.', src: '/img/icons/icon-invest.png', alt: 'inversión' },
    ]

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

    async function onSubmit(payload: any) {
        const csrf = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || ''
        const res = await fetch('/formularios/enviar', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        })
        if (res.ok) {
            closeBusinessModal()
            return
        }
        // opcional: ver error
        const err = await res.json().catch(() => ({}))
        console.error('Error formulario', res.status, err)
    }

    function openWhatsApp() {
        window.open('https://wa.me/5217774225973', '_blank')
    }

    type AnyCredit = any
    const weeklyCredits = computed<AnyCredit[]>(() => credits.filter((c: AnyCredit) => c.schedule === 'Semanal'))
    const activeCredit = ref<string>('')

    // Evita un scroll automatico y abre modal si viene el parametro
    onMounted(() => {
        const params = new URLSearchParams(window.location.search)
        const shouldOpen = params.get('solicitar') === '1'
        if (shouldOpen) {
            openBusinessModal()
            return
        }
        requestAnimationFrame(() => {
            window.scrollTo({ top: 0, left: 0, behavior: 'auto' })
            requestAnimationFrame(() => {
            window.scrollTo({ top: 0, left: 0, behavior: 'auto' })
            })
        })
    })

    const creditTabs = computed<SegmentTabItem[]>(() =>
        weeklyCredits.value.map((c: AnyCredit, idx: number) => ({
            key: String(c.id ?? c.modalId ?? idx),
            label: String(c.payments ?? `Plan ${idx + 1}`),
            iconSrc: c.icon,
            iconAlt: c.alt ?? String(c.payments ?? `Plan ${idx + 1}`),
        }))
    )

    const currentCredit = computed<AnyCredit | null>(() => {
        const key = activeCredit.value
        const found = weeklyCredits.value.find((c: AnyCredit, idx: number) => String(c.id ?? c.modalId ?? idx) === key)
        return found ?? weeklyCredits.value[0] ?? null
    })

    const weeklyOverridesByPlan: Record<
    string,
    {
        esquema: string
        plazo: string
        montoInicial: string
        montoMinimo: string
        montoMaximo: string
        poliza: string
        multa: string
        aumento: string
        costos: string
        cat: string
    }
    > = {
        '12': {
            esquema: 'Semanal',
            plazo: '12 pagos',
            montoInicial: '$3,000.00, $4,000.00, $5,000.00',
            montoMinimo: '$3,000.00',
            montoMaximo: '$25,000.00',
            poliza: '$100',
            multa: '$12.50 por cada $1000',
            aumento: '$1,000.00 cada ciclo, de acuerdo a política de aumentos',
            costos: 'No Aplica',
            cat: '2105.39%',
        },
        '16': {
            esquema: 'Semanal',
            plazo: '12 pagos',
            montoInicial: '$5,000.00',
            montoMinimo: '$5,000.00',
            montoMaximo: '$25,000.00',
            poliza: '$100',
            multa: '$12.50 por cada $1000',
            aumento: '$1,000.00 cada ciclo, de acuerdo a política de aumentos',
            costos: 'No Aplica',
            cat: '2105.39%',
        },
        '20': {
            esquema: 'Semanal',
            plazo: '12 pagos',
            montoInicial: '$10,000.00',
            montoMinimo: '$10,000.00',
            montoMaximo: '$50,000.00',
            poliza: '$100',
            multa: '$12.50 por cada $1000',
            aumento: '$1,000.00 por cada ciclo de acuerdo a política de aumentos',
            costos: 'No Aplica',
            cat: '2015.39%',
        },
        '24': {
            esquema: 'Semanal',
            plazo: '12 pagos',
            montoInicial: '$10,000.00',
            montoMinimo: '$10,000.00',
            montoMaximo: '$50,000.00',
            poliza: '$100',
            multa: '$12.50 por cada $1000',
            aumento: '$1,000.00 por cada ciclo de acuerdo a política de aumentos',
            costos: 'No Aplica',
            cat: '2105.39%',
        },
    }

    function extractPlanNumberFromPayments(payments: any): string | null {
        const s = String(payments ?? '')
        const m = s.match(/\d+/)
        return m?.[0] ?? null
    }

    const creditView = computed(() => {
        const c = currentCredit.value
        if (!c) return null
        const specs = (c.specs ?? {}) as any
        const planNum = extractPlanNumberFromPayments(c.payments)
        const ov = planNum ? weeklyOverridesByPlan[planNum] : undefined
        // Si encontramos override, usamos EXACTO lo de las imágenes.
        const creditRange = String(c.creditRange ?? specs.creditRange ?? '')
        const fallbackMontoMinimo =
            specs.montoMinimo ?? specs.monto_minimo ?? (creditRange.includes('a') ? creditRange.split('a')[0].replace('de', '').trim() : creditRange)
        const fallbackMontoMaximo =
            specs.montoMaximo ?? specs.monto_maximo ?? (creditRange.includes('a') ? creditRange.split('a')[1]?.trim() : '')

        return {
            titulo: specs.titulo ?? c.title ?? c.nombre ?? 'Crédito',
            esquema: ov?.esquema ?? (specs.esquema ?? c.schedule ?? 'Semanal'),
            plazo: ov?.plazo ?? (specs.plazo ?? c.payments ?? ''),
            montoInicial: ov?.montoInicial ?? 'Sujeto a disponibilidad de pago',
            montoMinimo: ov?.montoMinimo ?? (fallbackMontoMinimo || '—'),
            montoMaximo: ov?.montoMaximo ?? (fallbackMontoMaximo || '—'),
            cat: ov?.cat ?? (specs.cat ?? specs.CAT ?? c.cat ?? '—'),
            poliza: ov?.poliza ?? (specs.poliza ?? c.poliza ?? '—'),
            multa: ov?.multa ?? (specs.multa ?? c.multa ?? '—'),
            aumento: ov?.aumento ?? (specs.aumento ?? c.aumento ?? '—'),
            costos: ov?.costos ?? (specs.costos ?? c.costos ?? '—'),
            icon: c.icon,
            alt: c.alt ?? 'Crédito',
        }
    })
</script>

<template>
    <Head title="Impulsa tu negocio | Mr Lana" />
    <PublicLayout>
        <!-- MODAL -->
        <BusinessLoanRequestModal :open="openModal" :branches="branches" context="impulsa_negocio" @close="closeBusinessModal" @submit="onSubmit" />

        <!-- Banner Superior -->
        <div class="relative w-full overflow-hidden">
            <picture class="block w-full">
                <!-- Desktop -->
                <source media="(min-width: 768px)" srcset="/img/business-banner-1.jpg" />
                <!-- Mobile -->
                <img src="/img/bg-bussines-mobile.jpg" alt="Banner negocio"
                class="block w-full h-auto object-contain" draggable="false"/>
            </picture>

            <!-- Overlay SOLO desktop -->
            <div class="absolute inset-0 pointer-events-none hidden md:block
            bg-gradient-to-b from-black/55 via-black/30 to-black/55"/>

            <!-- CTA -->
            <div class="absolute inset-0 z-10 flex items-end justify-end">
                <div class="w-full px-4 pb-5 sm:pb-6 md:pb-7">
                <div class="mx-auto max-w-[760px] text-center pointer-events-auto">
                    <button type="button" @click="openBusinessModal"
                    class="inline-flex items-center justify-center
                    rounded-full bg-black/70 px-6
                    sm:w-[180px] md:w-[230px] lg:w-[300px] xl:w-[340px]
                    2xl:w-[400px] py-2 sm:py-2 md:py-5 lg:py-6 xl:py-7 2xl:py-8
                    text-base sm:text-lg md:text-2xl lg:text-3xl xl:text-4xl 2xl:text-5xl font-extrabold text-white
                    shadow-lg ring-1 ring-white/15 transition
                    hover:bg-black/80 hover:scale-[1.01] active:scale-[0.99]">
                    Solicitar ahora
                    </button>
                </div>
                </div>
            </div>
        </div>
                <!-- Pasos -->
        <section class="bg-white py-10 sm:py-12 md:py-14 lg:py-16 px-4 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-10 sm:mb-11 md:mb-12">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold
                    text-black uppercase tracking-tight">
                        PASOS PARA OBTENER TU CRÉDITO
                    </h2>
                </div>

                <div class="grid gap-4 sm:gap-5 md:gap-6"
                style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
                    <article v-for="(s, idx) in steps" :key="`${idx}-${s.stepTitle}`"
                    class="group relative rounded-2xl ring-1 bg-teal-300/5 ring-teal-300/5
                    p-5 sm:p-6
                    shadow-[0_22px_70px_-55px_rgba(0,0,0,0.95)]
                    transition duration-300
                    hover:-translate-y-1 hover:bg-white/[0.085]
                    hover:ring-emerald-400/30">
                        <!-- Glow suave -->
                        <div class="pointer-events-none absolute inset-0 rounded-2xl opacity-0
                        transition duration-300 group-hover:opacity-100"
                        style="background: radial-gradient(520px circle at 18% 0%, rgba(16,185,129,.18), transparent 58%);">
                        </div>

                        <!-- Shine sutil -->
                        <div class="pointer-events-none absolute inset-0 rounded-2xl opacity-0
                        transition duration-300 group-hover:opacity-100"
                        style="background: linear-gradient(110deg, transparent 0%, rgba(255,255,255,.06) 12%, transparent 24%);">
                        </div>

                        <div class="relative flex items-start gap-4">
                            <div class="shrink-0 grid h-12 w-12 place-items-center rounded-2xl
                            bg-black/5 ring-1 ring-black/5
                            transition duration-300
                            group-hover:bg-emerald-400/10 group-hover:ring-emerald-400/30">
                                <img :src="s.src" :alt="s.alt" class="h-7 w-7 opacity-95" />
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-base sm:text-lg font-extrabold text-black leading-snug">
                                    {{ s.stepTitle }}
                                </h3>

                                <p class="mt-2 text-sm sm:text-base text-black leading-relaxed">
                                    {{ s.stepSubtitle }}
                                </p>
                            </div>
                        </div>

                        <!-- micro-separador elegante -->
                        <div class="relative mt-4 sm:mt-5 h-px w-full bg-white/0
                        group-hover:bg-white/10 transition duration-300"></div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Créditos (Tabs) -->
        <section class="py-12 md:py-16 bg-gray-50 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-10 md:mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        CONTAMOS CON DIFERENTES OPCIONES PARA TI
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600">
                        Conoce los créditos semanales para tu negocio, <b>fácil y rápido</b>
                    </p>
                </div>

                <div class="rounded-2xl bg-white p-5 sm:p-7 md:p-8 shadow-lg
                ring-1 ring-gray-200">
                    <SegmentTabs v-model="activeCredit" :items="creditTabs" aria-label="Créditos Semanales">
                        <template #default>
                            <div v-if="creditView" class="grid grid-cols-1
                            lg:grid-cols-[240px_1fr] gap-6 lg:gap-8 items-start">
                                <div class="flex items-center justify-center lg:justify-start">
                                <!-- Icono MÁS GRANDE para que se distinga -->
                                    <img :src="creditView.icon" :alt="creditView.alt"
                                    class="h-32 w-32 sm:h-36 sm:w-36 md:h-40 md:w-40
                                    lg:h-44 lg:w-44"/>
                                </div>

                                <div>
                                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                                        {{ creditView.titulo }}
                                    </h3>

                                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Esquema</p>
                                            <p class="font-bold text-slate-900">{{ creditView.esquema }}</p>
                                        </div>

                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Plazo</p>
                                            <p class="font-bold text-slate-900">{{ creditView.plazo }}</p>
                                        </div>

                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Monto inicial</p>
                                            <p class="font-bold text-slate-900">{{ creditView.montoInicial }}</p>
                                        </div>

                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Monto mínimo</p>
                                            <p class="font-bold text-slate-900">{{ creditView.montoMinimo }}</p>
                                        </div>

                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Monto máximo</p>
                                            <p class="font-bold text-slate-900">{{ creditView.montoMaximo }}</p>
                                        </div>

                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">CAT</p>
                                            <p class="font-bold text-slate-900">{{ creditView.cat }}</p>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <p class="text-slate-500 text-sm mb-2">Condiciones</p>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                                    <p class="text-xs font-semibold text-slate-500">Póliza</p>
                                                    <p class="mt-1 font-bold text-slate-900">{{ creditView.poliza }}</p>
                                                </div>
                                                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                                    <p class="text-xs font-semibold text-slate-500">Multa</p>
                                                    <p class="mt-1 font-bold text-slate-900">{{ creditView.multa }}</p>
                                                </div>
                                                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                                    <p class="text-xs font-semibold text-slate-500">Aumento</p>
                                                    <p class="mt-1 font-bold text-slate-900">{{ creditView.aumento }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2 rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Costos</p>
                                            <p class="font-semibold text-slate-900">{{ creditView.costos }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </SegmentTabs>
                </div>

                <!-- CTA WhatsApp (mismo número que Impulsa.t) -->
                <div class="text-center mt-12 md:mt-16">
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                        ¿Ya sabes cuál te conviene?
                    </h3>

                    <button type="button" @click="openWhatsApp"
                    class="inline-flex items-center justify-center px-7 py-4 sm:px-8
                    sm:py-4 bg-gradient-to-r from-green-400 to-blue-500
                    text-white font-bold rounded-full
                    hover:opacity-90 transition-opacity shadow-lg">
                        Solicita tu préstamo
                        <img src="/img/icons/whats-icon.svg" class="ml-3 w-6 h-6" alt="WhatsApp" />
                    </button>
                </div>
            </div>
        </section>

        <!-- Banner App Store -->
        <BannerAppStore />

        <br /><br />

        <!-- Vacantes -->
        <div class="relative">
            <CtaSection
                :sources="{
                    base: '/img/bg-work-mobile.jpg',   // <sm
                    sm: '/img/bg-work-mobile.jpg',     // >=sm <md
                    md: '/img/bg-work-mobile.jpg',     // >=md <lg
                    lg: '/img/banner-employees.jpg',   // >=lg <xl
                    xl: '/img/banner-employees.jpg',   // >=xl <2xl
                    '2xl': '/img/banner-employees.jpg' // >=2xl
                }"
                alt="Bolsa de trabajo"
                button-text="Consulta nuestra bolsa de trabajo"
                @click="handleOpenVacancies()"
                :button-class="'min-w-[180px] lg:min-w-[280px] lg:px-12 lg:py-6 xl:px-16 xl:py-8 lg:text-xl xl:text-2xl'"
            />
        </div>

        <br /><br />
    </PublicLayout>
</template>

<style scoped>
    .bg-cover {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>
