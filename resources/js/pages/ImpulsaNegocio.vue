<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import { onMounted, ref } from 'vue'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import Container from '@/components/ui/Container.vue'
    import StepBanner from '@/components/impulsaN/StepBanner.vue'
    import PanelCredit from '@/components/impulsaN/PanelCredit.vue'
    import BannerAppStore from '@/components/home/AppDownloadBanner.vue'
    import LoanRequestForm from '@/components/forms/LoanRequestForm.vue'
    import BusinessLoanRequestModal from '@/components/forms/BusinessLoanRequestModal.vue'
    import { branches } from '@/data/sucursales'
    import { credits } from '@/data/credits'
    
    function handleOpenVacancies() {
        // Emitir evento global que PublicLayout puede escuchar
        window.dispatchEvent(new CustomEvent('open-vacancies-global'))
    }
    
    const steps = [
        {
            stepTitle: '1. Documentación',
            stepSubtitle: 'Entregar al gestor de crédito tus documentos',
            src: '/img/icons/icon-doc.png',
            alt: 'documentos'
        },
        {
            stepTitle: '2. Formato',
            stepSubtitle: 'Llena los formatos de crédito Mr. lana.',
            src: '/img/icons/icon-pencil.png',
            alt: 'lapiz'
        },
        {
            stepTitle: '3. Acepta la propuesta',
            stepSubtitle: 'Grabamos un pequeño video solicitando tu crédito, donde se aprecia tu negocio.',
            src: '/img/icons/icon-video.png',
            alt: 'video'
        },
        {
            stepTitle: '4. Evaluación de tu video.',
            stepSubtitle: 'En 15 minutos te notificamos si tu crédito ha sido autorizado o rechazado.',
            src: '/img/icons/icon-time.png',
            alt: 'tiempo'
        },
        {
            stepTitle: '5. Gestor de crédito',
            stepSubtitle: 'Realizaremos una grabación de desembolso de crédito.',
            src: '/img/icons/icon-money.png',
            alt: 'dinero'
        },
        {
            stepTitle: '6. Recibe tu dinero.',
            stepSubtitle: 'Disfruta e invierte tu crédito y haz crecer tu negocio.',
            src: '/img/icons/icon-invest.png',
            alt: 'inversión'
        }
    ]
    
    const weeklyCredits = credits.filter(credit => credit.schedule === 'Semanal')
        
        // Modal
    const openModal = ref(false)

    function openBusinessModal() {
        openModal.value = true
    }

    function closeBusinessModal() {
        openModal.value = false

        // Limpia el query param para que si refrescan no se vuelva a abrir
        const url = new URL(window.location.href)
        url.searchParams.delete('solicitar')
        window.history.replaceState({}, '', url.toString())
        }

        function onSubmit(payload: any) {
        console.log('submit impulsa negocio', payload)
        // Aquí conectas tu endpoint (Inertia post / axios / fetch)
        closeBusinessModal()
        }

        onMounted(() => {
        const params = new URLSearchParams(window.location.search)
        if (params.get('solicitar') === '1') {
            openBusinessModal()
        }
    })

    
</script>
    
    <template>
        <Head title="Impulsa tu negocio | Mr Lana" />
        <PublicLayout>
            <!-- MODAL -->
            <BusinessLoanRequestModal
                :open="openModal"
                :branches="branches"
                @close="closeBusinessModal"
                @submit="onSubmit"
            />
            <!-- Banner Superior -->
            <div class="relative">
                <img src="/img/business-banner-1.jpg" class="hidden md:block w-full h-auto" alt="Banner negocio desktop"/>
                <img src="/img/bg-bussines-mobile.jpg" class="block md:hidden w-full h-auto" alt="Banner negocio mobile"/>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white">
                        <h1 class="text-4xl md:text-6xl font-bold [text-shadow:_0_2px_8px_rgb(0_0_0_/_90%)]">Mejora el NIVEL</h1>
                        <p class="text-2xl md:text-4xl font-bold [text-shadow:_0_2px_8px_rgb(0_0_0_/_90%)]">de tu NEGOCIO</p>
                    </div>
                </div>
            </div>
            <!-- Sección de Pasos (con fondo gris) -->
            <div class="py-12 md:py-16 bg-gray-100">
                <Container>
                    <h2 class="text-center text-3xl md:text-4xl font-bold text-gray-900 mb-10 md:mb-12">
                        PASOS PARA OBTENER TU CRÉDITO
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <StepBanner
                        v-for="step in steps"
                        :key="step.stepTitle"
                        :step-title="step.stepTitle"
                        :step-subtitle="step.stepSubtitle"
                        :src="step.src"
                        :alt="step.alt"
                        />
                    </div>
                </Container>
            </div>
    
            <!-- Sección Quiénes Somos con bordes laterales blancos -->
            <div class="relative w-full bg-white"> <!-- Fondo blanco para bordes -->
                <!-- Contenedor con padding blanco a los lados -->
                <div class="px-4 sm:px-6 md:px-8 lg:px-10 xl:px-12 2xl:px-16">
                    <!-- Sección interna con la imagen -->
                    <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl md:rounded-4xl">
                        <!-- Imagen de fondo -->
                        <div class="absolute inset-0 bg-[url('/img/home/banner-gradient.png')] bg-cover bg-center" />
                        
                        <!-- Contenido sobre la imagen -->
                        <div class="relative z-10 py-12 sm:py-16 md:py-20 lg:py-24 xl:py-28">
                            <Container>
                                <div class="max-w-6xl mx-auto px-4 sm:px-6 md:px-8 lg:px-10 xl:px-12">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 lg:gap-10 xl:gap-12 items-center">
                                        <!-- Título -->
                                        <div class="text-center lg:text-left">
                                            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white">
                                                ¿QUIÉNES SOMOS?
                                            </h2>
                                        </div>
                                        
                                        <!-- Texto -->
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
    
            <!-- Sección de Créditos -->
            <div class="py-12 md:py-16 bg-gray-50">
                <Container>
                    <div class="text-center mb-10 md:mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            CONTAMOS CON DIFERENTES OPCIONES PARA TI
                        </h2>
                        <p class="text-lg md:text-xl text-gray-600">
                            Conoce los créditos semanales para tu negocio, <b>fácil y rápido</b>
                        </p>
                    </div>
            
                    <!-- Créditos Semanales -->
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-center text-gray-900 mb-8">
                            Semanal
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <PanelCredit
                            v-for="credit in weeklyCredits"
                            :key="credit.id"
                            :src-credit-icon="credit.icon"
                            :alt-icon="credit.alt"
                            :schedule="credit.schedule"
                            :payments="credit.payments"
                            :credit="credit.creditRange"
                            :modal-id="credit.modalId"
                            :specs="credit.specs"
                            />
                        </div>
                    </div>
            
                    <!-- Llamado a la acción (también abre el modal si quieres) -->
                    <div class="text-center mt-12 md:mt-16">
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                        ¿Ya sabes cuál te conviene?
                    </h3>

                    <button
                        type="button"
                        @click="openBusinessModal"
                        class="inline-flex items-center justify-center px-7 py-4 sm:px-8 sm:py-4
                            bg-gradient-to-r from-green-400 to-blue-500 text-white font-bold rounded-full
                            hover:opacity-90 transition-opacity shadow-lg"
                    >
                        Solicita tu préstamo
                        <img src="/img/icons/whats-icon.svg" class="ml-3 w-6 h-6" alt="WhatsApp" />
                    </button>
                    </div>
                </Container>
            </div>
    
            <!-- Banner App Store -->
            <BannerAppStore />

            <br><br>
    
            <!-- Sección de Vacantes con imágenes diferentes para mobile/desktop -->
            <div class="relative">
                <!-- Imagen para mobile (se muestra solo en mobile) -->
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
                
                <!-- Imagen para desktop (se muestra solo en desktop) -->
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

            <br><br>
    
        </PublicLayout>
    </template>
    
    <style scoped>
    /* Asegurar que la imagen de fondo cubra bien en todos los dispositivos */
    .bg-cover {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    /* Responsive para la sección de vacantes */
    @media (min-width: 640px) {
        .bg-cover {
            min-height: 300px;
        }
    }
    
    @media (min-width: 768px) {
        .bg-cover {
            min-height: 400px;
        }
    }
    
    @media (min-width: 1024px) {
        .bg-cover {
            min-height: 500px;
        }
    }
    
    @media (min-width: 1280px) {
        .bg-cover {
            min-height: 600px;
        }
    }
    
    .bg-gradient-to-r {
        background-size: 200% 200%;
        animation: gradient 15s ease infinite;
    }
    
    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    </style>