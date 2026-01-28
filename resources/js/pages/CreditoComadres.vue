<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import CtaSection from '@/components/vacancies/CtaSection.vue'
    import MrBannerAppStore from '@/components/home/AppDownloadBanner.vue'
    import BusinessLoanRequestModal from '@/components/forms/BusinessLoanRequestModal.vue'
    import SegmentTabs, { type SegmentTabItem } from '@/components/ui/SegmentTabs.vue'
    import { branches } from '@/data/sucursales'
    import { ref, onMounted, computed } from 'vue'
    import { swalOk, swalErr, swalLoading, swalClose } from '@/lib/swal'

    const sending = ref(false)

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

    async function onSubmit(payload: any) {
        if (sending.value) return
        const csrf = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || ''
        sending.value = true
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
            swalClose()
            await swalOk('Listo: tu solicitud fue enviada. En breve te contactamos.')
            return
            }
            const err = await res.json().catch(() => ({}))
            const msg =
            err?.message ||
            (err?.errors ? (Object.values(err.errors).flat() as any[]).join(' ') : '') ||
            'No se pudo enviar. Intenta de nuevo.'
            swalClose()
            await swalErr(msg)
        } catch (e) {
            swalClose()
            await swalErr('Sin conexión o servidor no disponible. Intenta en un momento.')
        } finally {
            sending.value = false
        }
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
        comadres16: {
            titulo: 'Crédito Comadres 16',
            esquema: 'Semanal',
            plazo: '16 pagos (lunes a viernes)',
            montoInicial: '$5,000.00 hasta $8,000.00',
            montoMinimo: '$5,000.00',
            montoMaximo: '$100,000.00',
            poliza: '1.6% del monto autorizado',
            multa: '5% del monto del pago',
            aumento: 'Hasta un 25% del monto de pago del ciclo a renovar',
            costos: [
                'Comisión por administración del crédito: 1% del monto de crédito',
                'Comisión por apertura o renovación de crédito: 1% del monto de crédito',
                'Comisión por gastos de verificación: 1% del monto de crédito',
            ],
            cat: '244.80% este sobre un monto promedio de $10,000.00 SIN IVA',
            icon: '/img/icons/icon-credit-crece24.png',
            alt: 'Comadres 16',
        },
    } as const

    type CreditKey = keyof typeof creditSpecs
    const activeCredit = ref<CreditKey>('comadres16')
    const creditTabs = computed<SegmentTabItem[]>(() => [
        { key: 'comadres16', label: 'Comadres' },
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
        <BusinessLoanRequestModal
        :open="openModal"
        :branches="branches"
        context="credito_comadres"
        :sending="sending"
        @close="closeBusinessModal"
        @submit="onSubmit"
        />

        <!-- HERO -->
        <div class="relative w-full overflow-hidden">
            <picture class="block w-full">
                <source media="(min-width: 1024px)" srcset="/img/home/Slider-3.jfif" />
                <img
                src="/img/home/Slider-3.jfif"
                alt="Crédito Comadres"
                class="block w-full h-auto object-contain"
                draggable="false"
                />
            </picture>

            <!-- Overlay (no afecta el tamaño de la imagen) -->
            <div class="absolute inset-0 pointer-events-none bg-gradient-to-b from-black/55 via-black/30 to-black/55" />

            <!-- CTA -->
            <div class="absolute inset-0 z-10 flex items-end justify-center">
                <div class="w-full px-4 pb-5 sm:pb-6 md:pb-7">
                    <div class="mx-auto max-w-[820px] text-center pointer-events-auto">
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

        <!-- ===================== PASOS CRÉDITO COMADRES ===================== -->
        <div class="bg-white py-10 sm:py-12 px-4 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold
                    text-black uppercase tracking-tight">
                        PASOS CRÉDITO COMADRES
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div v-for="s in steps" :key="s.title"
                    class="rounded-2xl bg-teal-300/5 ring-teal-300/5 ring- p-6
                    shadow-[0_20px_60px_-45px_rgba(0,0,0,0.85)]
                    transition hover:bg-white/[0.085]
                    hover:ring-emerald-400/30 hover:-translate-y-[1px]">
                        <div class="flex items-center gap-4">
                            <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white/10 ring-1 ring-white/10">
                                <img :src="s.icon" :alt="s.alt" class="h-7 w-7"/>
                            </div>
                            <h3 class="text-base sm:text-lg font-extrabold text-black">
                                {{ s.title }}
                            </h3>
                        </div>
                        <p class="mt-3 text-sm sm:text-base text-black/75 leading-relaxed">
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
                </div>

                <div class="rounded-2xl bg-white p-5 sm:p-7 md:p-8 shadow-lg
                ring-1 ring-gray-200">
                    <SegmentTabs v-model="activeCredit" :items="creditTabs" aria-label="Créditos Comadres">
                        <template #default>
                            <!-- Layout 1 columna en mobile, 12 cols en lg+ -->
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
                                <!-- Columna izquierda (branding / resumen) -->
                                <aside class="lg:col-span-4">
                                    <div class="rounded-2xl bg-slate-50 ring-1 ring-slate-200 p-5 sm:p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="grid h-14 w-14 place-items-center rounded-2xl bg-white ring-1 ring-slate-200 overflow-hidden">
                                                <img :src="currentCredit.icon"
                                                class="h-10 w-10 object-contain"
                                                draggable="false"/>
                                            </div>

                                            <div>
                                                <p class="text-xs font-semibold tracking-wide text-slate-500 uppercase">Producto</p>
                                                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight">
                                                    {{ currentCredit.titulo }}
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="mt-5 grid grid-cols-1 gap-3">
                                            <div class="rounded-xl bg-white p-4 ring-1 ring-slate-200">
                                                <p class="text-slate-500 text-sm">Esquema</p>
                                                <p class="font-extrabold text-slate-900">{{ currentCredit.esquema }}</p>
                                            </div>

                                            <div class="rounded-xl bg-white p-4 ring-1 ring-slate-200">
                                                <p class="text-slate-500 text-sm">Plazo</p>
                                                <p class="font-extrabold text-slate-900">{{ currentCredit.plazo }}</p>
                                            </div>

                                            <div class="rounded-xl bg-white p-4 ring-1 ring-slate-200">
                                                <p class="text-slate-500 text-sm">CAT</p>
                                                <p class="font-extrabold text-slate-900 leading-snug">{{ currentCredit.cat }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </aside>

                                <!-- Columna derecha (detalles) -->
                                <section class="lg:col-span-8">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Monto inicial</p>
                                            <p class="font-extrabold text-slate-900">{{ currentCredit.montoInicial }}</p>
                                        </div>

                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Monto mínimo</p>
                                            <p class="font-extrabold text-slate-900">{{ currentCredit.montoMinimo }}</p>
                                        </div>

                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Monto máximo</p>
                                            <p class="font-extrabold text-slate-900">{{ currentCredit.montoMaximo }}</p>
                                        </div>

                                        <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                            <p class="text-slate-500 text-sm">Costos</p>
                                            <ul class="mt-2 space-y-1 text-slate-900">
                                                <li v-for="(c, i) in currentCredit.costos" :key="i"
                                                class="flex gap-2 text-sm sm:text-base font-semibold leading-snug">
                                                    <span class="mt-[0.45rem] h-1.5 w-1.5 shrink-0 rounded-full bg-slate-400"></span>
                                                    <span>{{ c }}</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <p class="text-slate-500 text-sm mb-2">Condiciones</p>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                                    <p class="text-xs font-semibold text-slate-500">Póliza</p>
                                                    <p class="mt-1 font-extrabold text-slate-900">{{ currentCredit.poliza }}</p>
                                                </div>

                                                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                                    <p class="text-xs font-semibold text-slate-500">Multa</p>
                                                    <p class="mt-1 font-extrabold text-slate-900">{{ currentCredit.multa }}</p>
                                                </div>

                                                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                                                    <p class="text-xs font-semibold text-slate-500">Aumento</p>
                                                    <p class="mt-1 font-extrabold text-slate-900">{{ currentCredit.aumento }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
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
