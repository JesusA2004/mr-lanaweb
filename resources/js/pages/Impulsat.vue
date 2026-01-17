<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import Container from '@/components/ui/Container.vue'
    import LoanRequestForm from '@/components/forms/LoanRequestForm.vue'
    import MrBannerAppStore from '@/components/home/AppDownloadBanner.vue' // Asumo que tienes este componente
    import { branches } from '@/data/sucursales'
    import { ref } from 'vue'
    
    // Estados para los modales de créditos
    const showModalCrece12 = ref(false)
    const showModalCrece24 = ref(false)
    const showModalCrece8q = ref(false)
    const showModalCrece12q = ref(false)

    function handleOpenVacancies() {
        // Emitir evento global que PublicLayout puede escuchar
        window.dispatchEvent(new CustomEvent('open-vacancies-global'))
    }
    
    // Datos de los créditos (deberías mover esto a un archivo de datos)
    const creditSpecs = {
      crece12: {
        esquema: "Semanal",
        plazo: "12 pagos",
        montoInicial: "Sujeto a disponibilidad de pago",
        montoMinimo: "$5,000.00",
        montoMaximo: "$100,000.00",
        poliza: "$100",
        multa: "$12.50 por cada $1000",
        aumento: "$1,000.00 por cada ciclo de acuerdo a política de aumentos",
        costos: "No aplica",
        cat: "1887.06%"
      },
      crece24: {
        esquema: "Semanal",
        plazo: "24 pagos",
        montoInicial: "Sujeto a disponibilidad de pago",
        montoMinimo: "$10,000.00",
        montoMaximo: "$100,000.00",
        poliza: "$100",
        multa: "$12.50 por cada $1000",
        aumento: "$1,000.00 por cada ciclo de acuerdo a política de aumentos",
        costos: "No aplica",
        cat: "1318.31%"
      },
      crece8q: {
        esquema: "Quincenal",
        plazo: "8 pagos",
        montoInicial: "Sujeto a disponibilidad de pago",
        montoMinimo: "$10,000.00",
        montoMaximo: "$100,000.00",
        polizaMenor: "$130.00",
        polizaMayor: "1.3% del monto otorgado",
        multa: "10% del monto de pago",
        aumento: "Hasta un 25% del monto de pago del ciclo anterior",
        comisionApertura: "5% del monto de crédito",
        comisionAumento: "5% sobre el aumento de crédito",
        cat: "941.51%"
      },
      crece12q: {
        esquema: "Quincenal",
        plazo: "12 pagos",
        montoInicial: "Sujeto a disponibilidad de pago",
        montoMinimo: "$10,000.00",
        montoMaximo: "$100,000.00",
        polizaMenor: "$130.00",
        polizaMayor: "1.3% del monto otorgado",
        multa: "10% del monto de pago",
        aumento: "Hasta un 25% del monto de pago del ciclo anterior",
        comisionApertura: "5% del monto de crédito",
        comisionAumento: "5% sobre el aumento de crédito",
        cat: "1075.86%"
      }
    }
    
    function onSubmit(payload: any) {
      console.log('submit impulsat', payload)
    }
    
    function openWhatsApp() {
      window.open('https://wa.me/5217773488457')
    }
    </script>
    
    <template>
      <Head title="Impulsa.t | Mr Lana" />
      <PublicLayout>
        <!-- Banner Superior con fondo de imagen y texto -->
        <div class="relative w-full overflow-hidden">
          <!-- Imagen para desktop -->
          <img 
            src="/img/impulsat-banner.jpg" 
            class="hidden md:block w-full h-auto max-h-[500px] object-cover" 
            alt="Banner negocio desktop"
          />
          <!-- Imagen para mobile -->
          <img 
            src="/img/bg-impulsat-mobile.jpg" 
            class="block md:hidden w-full h-auto max-h-[400px] object-cover" 
            alt="Banner negocio mobile"
          />
          
          <!-- Texto superpuesto (Versión 2: con sombra) -->
          <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white px-4">
              <h1 class="text-4xl md:text-6xl font-bold [text-shadow:_0_2px_8px_rgb(0_0_0_/_90%)] leading-tight">
                Mejora el NIVEL
              </h1>
              <p class="text-2xl md:text-4xl font-bold [text-shadow:_0_2px_8px_rgb(0_0_0_/_90%)] leading-tight">
                de tu NEGOCIO
              </p>
            </div>
          </div>
        </div>
    
        <!-- Sección de Pasos para Obtener Crédito -->
        <div class="bg-gray-900 py-8 px-4 overflow-hidden">
          <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
              <h2 class="text-3xl md:text-4xl font-bold text-white uppercase">
                PASOS PARA OBTENER TU CRÉDITO
              </h2>
            </div>
    
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
              <!-- Paso 1 -->
              <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
                <div class="mb-4">
                  <img src="/img/icons/icon-doc.png" alt="Documentos" class="w-16 h-16 mx-auto">
                </div>
                <h3 class="text-xl font-bold text-white mb-2">1. Documentación</h3>
                <p class="text-gray-300">Entrega al gestor de crédito tus documentos</p>
              </div>
    
              <!-- Paso 2 -->
              <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
                <div class="mb-4">
                  <img src="/img/icons/icon-pencil.png" alt="Lápiz" class="w-16 h-16 mx-auto">
                </div>
                <h3 class="text-xl font-bold text-white mb-2">2. Formato</h3>
                <p class="text-gray-300">Firma los formatos de crédito Mr. lana.</p>
              </div>
    
              <!-- Paso 3 -->
              <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
                <div class="mb-4">
                  <img src="/img/icons/icon-video.png" alt="Video" class="w-16 h-16 mx-auto">
                </div>
                <h3 class="text-xl font-bold text-white mb-2">3. Acepta la propuesta</h3>
                <p class="text-gray-300">Grabamos un pequeño video, donde se aprecia tu casa o negocio.</p>
              </div>
    
              <!-- Paso 4 -->
              <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
                <div class="mb-4">
                  <img src="/img/icons/icon-time.png" alt="Tiempo" class="w-16 h-16 mx-auto">
                </div>
                <h3 class="text-xl font-bold text-white mb-2">4. Evaluación</h3>
                <p class="text-gray-300">En 15 minutos te notificamos si tu crédito ha sido autorizado</p>
              </div>
    
              <!-- Paso 5 -->
              <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-lg p-6 text-center">
                <div class="mb-4">
                  <img src="/img/icons/icon-money.png" alt="Dinero" class="w-16 h-16 mx-auto">
                </div>
                <h3 class="text-xl font-bold text-white mb-2">5. Desembolso</h3>
                <p class="text-gray-300">Espera la transferencia de pago a tu cuenta por concepto de desembolso de crédito por parte de Mr Lana y comienza a impulsar tus proyectos</p>
              </div>
            </div>
          </div>
        </div>
    
        <br>

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
        <div class="py-16 px-4 bg-gray-50">
          <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
              <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <span class="block">ESTA NUEVA OPCIÓN DE CRÉDITO ES PARA TI</span>
              </h2>
              <p class="text-xl text-gray-700">
                Conoce el nuevo crédito semanal para cumplir tu sueños, <span class="font-bold">fácil y rápido</span>
              </p>
            </div>
    
            <!-- Grid de Créditos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
              <!-- Crece12 -->
              <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                  <img src="/img/icons/icon-credit-crece12.png" alt="Crece12" class="w-20 h-20">
                  <button 
                    @click="showModalCrece12 = true"
                    class="px-6 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white font-bold rounded-full hover:opacity-90 transition"
                  >
                    Ver Especificaciones
                  </button>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Crédito Crece12</h3>
                <div class="space-y-3">
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Esquema:</span>
                    <span class="font-bold">Semanal</span>
                  </div>
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Plazo:</span>
                    <span class="font-bold">12 pagos</span>
                  </div>
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Monto:</span>
                    <span class="font-bold">de $5,000 a $100,000</span>
                  </div>
                </div>
              </div>
    
              <!-- Crece24 -->
              <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                  <img src="/img/icons/icon-credit-crece24.png" alt="Crece24" class="w-20 h-20">
                  <button 
                    @click="showModalCrece24 = true"
                    class="px-6 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white font-bold rounded-full hover:opacity-90 transition"
                  >
                    Ver Especificaciones
                  </button>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Crédito Crece24</h3>
                <div class="space-y-3">
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Esquema:</span>
                    <span class="font-bold">Semanal</span>
                  </div>
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Plazo:</span>
                    <span class="font-bold">24 pagos</span>
                  </div>
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Monto:</span>
                    <span class="font-bold">de $10,000 a $100,000</span>
                  </div>
                </div>
              </div>
    
              <!-- Crece8q -->
              <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                  <img src="/img/icons/icon-credit-crece8q.png" alt="Crece8q" class="w-20 h-20">
                  <button 
                    @click="showModalCrece8q = true"
                    class="px-6 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white font-bold rounded-full hover:opacity-90 transition"
                  >
                    Ver Especificaciones
                  </button>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Crédito Crece8q</h3>
                <div class="space-y-3">
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Esquema:</span>
                    <span class="font-bold">Quincenal</span>
                  </div>
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Plazo:</span>
                    <span class="font-bold">8 pagos</span>
                  </div>
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Monto:</span>
                    <span class="font-bold">de $10,000 a $100,000</span>
                  </div>
                </div>
              </div>
    
              <!-- Crece12q -->
              <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
                <div class="flex items-center justify-between mb-6">
                  <img src="/img/icons/icon-credit-crece12q.png" alt="Crece12q" class="w-20 h-20">
                  <button 
                    @click="showModalCrece12q = true"
                    class="px-6 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white font-bold rounded-full hover:opacity-90 transition"
                  >
                    Ver Especificaciones
                  </button>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Crédito Crece12q</h3>
                <div class="space-y-3">
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Esquema:</span>
                    <span class="font-bold">Quincenal</span>
                  </div>
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Plazo:</span>
                    <span class="font-bold">12 pagos</span>
                  </div>
                  <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Monto:</span>
                    <span class="font-bold">de $10,000 a $100,000</span>
                  </div>
                </div>
              </div>
            </div>
    
            <!-- Botón Solicitar Préstamo -->
            <div class="text-center mb-16">
              <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">
                ¿Ya sabes cuál te conviene?
              </h3>
              <button 
                @click="openWhatsApp"
                class="px-8 py-4 bg-gradient-to-r from-green-500 to-blue-500 text-white font-bold text-xl rounded-full hover:opacity-90 transition flex items-center justify-center mx-auto gap-3"
              >
                <span>Solicita tu préstamo</span>
                <img src="/img/icons/whats-icon.svg" alt="WhatsApp" class="w-6 h-6">
              </button>
            </div>
          </div>
        </div>
    
        <!-- Banner App Store -->
        <section class="py-8 px-4">
          <MrBannerAppStore />
        </section>
    
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