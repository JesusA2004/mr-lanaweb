<!-- resources/js/Pages/CreditoComadres/Index.vue -->
<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import CtaSection from '@/components/vacancies/CtaSection.vue'
    import MrBannerAppStore from '@/components/home/AppDownloadBanner.vue'
    import BusinessLoanRequestModal from '@/components/forms/BusinessLoanRequestModal.vue'
    import SegmentTabs, { type SegmentTabItem } from '@/components/ui/SegmentTabs.vue'
    import { branches } from '@/data/sucursales'
    import { ref, onMounted, computed } from 'vue'

    // Vacantes
    function handleOpenVacancies() {
        window.dispatchEvent(new CustomEvent('open-vacancies-global'))
    }

    // Modal solicitud
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
        console.log('submit credito-comadres', payload)
        closeBusinessModal()
    }

    onMounted(() => {
        const params = new URLSearchParams(window.location.search)
        if (params.get('solicitar') === '1') {
            openBusinessModal()
        }
    })

    // WhatsApp
    function openWhatsApp() {
        window.open('https://wa.me/5217774225973', '_blank')
    }

    // Créditos
    const creditSpecs = {
        crece12: {
            titulo: 'Crédito Comadres 12',
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
            alt: 'Comadres 12',
        },
        crece24: {
            titulo: 'Crédito Comadres 24',
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
            alt: 'Comadres 24',
        },
    } as const

    type CreditKey = keyof typeof creditSpecs
    const activeCredit = ref<CreditKey>('crece12')
    const creditTabs = computed<SegmentTabItem[]>(() => [
        { key: 'crece12', label: 'Comadres 12', iconSrc: creditSpecs.crece12.icon, iconAlt: creditSpecs.crece12.alt },
        { key: 'crece24', label: 'Comadres 24', iconSrc: creditSpecs.crece24.icon, iconAlt: creditSpecs.crece24.alt },
    ])
    const currentCredit = computed(() => creditSpecs[activeCredit.value])

    // Pasos Crédito Comadres
    const steps = [
        {
            title: '1. Forma tu grupo',
            desc: 'Consolida tu grupo de 10 o más mujeres comadres.',
            icon: '/img/icons/icon-doc.png',
            alt: 'Grupo',
        },
        {
            title: '2. Documentación',
            desc: 'Entrega la documentación requerida a tu asesor de crédito.',
            icon: '/img/icons/icon-pencil.png',
            alt: 'Documentación',
        },
        {
            title: '3. Validación de grupo',
            desc: 'Tu asesor verifica y garantiza que el grupo se apegue a sus políticas generales.',
            icon: '/img/icons/icon-video.png',
            alt: 'Validación de grupo',
        },
        {
            title: '4. Validación de negocio',
            desc: 'Tu asesor visita tu negocio para grabar un video de validación de negocio.',
            icon: '/img/icons/icon-time.png',
            alt: 'Validación de negocio',
        },
        {
            title: '5. Envío y verificación de solicitud',
            desc: 'Tu asesor solicita a Mr. Lana la pre autorización del crédito.',
            icon: '/img/icons/icon-money.png',
            alt: 'Solicitud',
        },
        {
            title: '6. Video de consolidación de grupo',
            desc: 'Tu asesor graba el video de consolidación de grupo. El ritual necesario.',
            icon: '/img/icons/icon-video.png',
            alt: 'Video consolidación',
        },
        {
            title: '7. Autorización y dispersión',
            desc: 'Tu asesor recibe la autorización y se procede con la dispersión para el desembolso del crédito a cada comadre.',
            icon: '/img/icons/icon-money.png',
            alt: 'Dispersión',
        },
    ] as const
</script>

<template>
    <Head title="Crédito Comadres" />
    <PublicLayout>
        <!-- MODAL -->
        <BusinessLoanRequestModal :open="openModal" :branches="branches"
        @close="closeBusinessModal" @submit="onSubmit" />

        <!-- HERO (usa /img/home/Slider-3.jfif) -->
        <div class="relative w-full overflow-hidden">
            <img src="/img/home/Slider-3.jfif"
            class="w-full h-auto max-h-[520px] object-cover object-center"
            alt="Crédito Comadres"/>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/55 via-black/30 to-black/55" />

            <!-- Texto -->
            <div class="pointer-events-none absolute inset-0 flex
            items-center justify-center">
                <div class="text-right text-white px-4">
                    <p class="mt-2 text-lg sm:text-xl md:text-3xl font-bold
                    [text-shadow:_0_2px_10px_rgb(0_0_0_/_85%)]">
                        Grupo, confianza y crecimiento.
                    </p>
                </div>
            </div>

            <!-- CTA -->
            <div class="absolute inset-0 z-10 flex items-end justify-center">
                <div class="w-full px-4 pb-5 sm:pb-6 md:pb-7">
                    <div class="mx-auto max-w-[820px] text-center pointer-events-auto">
                        <button type="button" @click="openBusinessModal"
                        class="inline-flex w-full sm:w-auto items-center justify-center
                        rounded-full bg-white/15 px-6 sm:px-10 py-3 sm:py-4
                        text-base sm:text-lg md:text-xl font-extrabold text-white
                        shadow-lg ring-1 ring-white/20 backdrop-blur
                        transition hover:bg-white/20 hover:scale-[1.01]
                        active:scale-[0.99]">
                            Solicitar ahora
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================== PASOS CRÉDITO COMADRES ===================== -->
        <div class="bg-zinc-950 py-10 sm:py-12 px-4 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold
                    text-white uppercase tracking-tight">
                        PASOS CRÉDITO COMADRES
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div v-for="s in steps" :key="s.title"
                    class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-6
                    shadow-[0_20px_60px_-45px_rgba(0,0,0,0.85)]
                    transition hover:bg-white/7 hover:-translate-y-[1px]">
                        <div class="flex items-center gap-4">
                            <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white/10 ring-1 ring-white/10">
                                <img :src="s.icon" :alt="s.alt" class="h-7 w-7"/>
                            </div>
                            <h3 class="text-base sm:text-lg font-extrabold text-white">
                                {{ s.title }}
                            </h3>
                        </div>
                        <p class="mt-3 text-sm sm:text-base text-white/75 leading-relaxed">
                            {{ s.desc }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CRÉDITOS (UN SOLO RECUADRO + Tabs) -->
        <div class="py-16 px-4 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">
                        PRODUCTO COMADRES
                    </h2>
                    <p class="text-base sm:text-lg md:text-xl text-gray-700">
                        Elige tu esquema y revisa condiciones en un solo panel. Sin vueltas.
                    </p>
                </div>

                <div class="rounded-2xl bg-white p-5 sm:p-7 md:p-8 shadow-lg
                ring-1 ring-gray-200">
                    <SegmentTabs v-model="activeCredit" :items="creditTabs" aria-label="Créditos Comadres">
                        <template #default>
                            <div class="grid grid-cols-1 lg:grid-cols-[220px_1fr]
                            gap-6 lg:gap-8 items-start">
                                <div class="flex items-center justify-center
                                lg:justify-start">
                                    <img :src="currentCredit.icon"
                                    :alt="currentCredit.alt"
                                    class="h-28 w-28 sm:h-32 sm:w-32 md:h-36 md:w-36
                                    lg:h-44 lg:w-44"/>
                                </div>

                                <div>
                                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                                        {{ currentCredit.titulo }}
                                    </h3>

                                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2
                                    gap-4">
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

                <!-- WhatsApp -->
                <div class="text-center mt-12">
                    <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6">
                        ¿Lista para armar tu grupo?
                    </h3>

                    <button type="button" @click="openWhatsApp"
                    class="px-8 py-4 bg-gradient-to-r from-green-500 to-sky-500
                    text-white font-extrabold text-lg sm:text-xl rounded-full
                    hover:opacity-95 transition flex items-center justify-center
                    mx-auto gap-3 shadow-[0_18px_60px_-35px_rgba(16,185,129,0.55)]">
                        <span>Solicitar Crédito Comadres</span>
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

        <br>
    </PublicLayout>
</template>

<style scoped>
    .banner-employees {
        background-image: url('/public/img/banner-employees.jpg');
        background-size: cover;
        background-position: center;
    }
</style>
