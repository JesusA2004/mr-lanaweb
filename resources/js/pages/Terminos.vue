<!-- resources/js/Pages/Terms/Index.vue -->
<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import Container from '@/components/ui/Container.vue'

const title = 'Términos y Condiciones | Mr Lana'
const description =
  'Términos y Condiciones de Mr Lana. Consulta las reglas de uso de la aplicación móvil y sitio web, modificaciones, permisos, servicios y alcance.'
const canonical = 'https://mr-lana.com/terminos-y-condiciones'
const ogImage = 'https://mr-lana.com/img/og/terminos-condiciones.png' // Ajusta si ya tienes uno

const jsonLd = {
  '@context': 'https://schema.org',
  '@type': 'WebPage',
  name: 'Términos y Condiciones',
  description,
  url: canonical,
  isPartOf: {
    '@type': 'WebSite',
    name: 'Mr Lana',
    url: 'https://mr-lana.com',
  },
}
</script>

<template>
  <Head :title="title">
    <!-- SEO base -->
    <meta name="description" :content="description" />
    <link rel="canonical" :href="canonical" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Mr Lana" />
    <meta property="og:title" :content="title" />
    <meta property="og:description" :content="description" />
    <meta property="og:url" :content="canonical" />
    <meta property="og:image" :content="ogImage" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="title" />
    <meta name="twitter:description" :content="description" />
    <meta name="twitter:image" :content="ogImage" />

    <!-- JSON-LD -->
    <meta type="application/ld+json" :content="JSON.stringify(jsonLd)" />
  </Head>

  <PublicLayout>
    <section class="relative overflow-hidden pt-20 sm:pt-24 md:pt-28 pb-10 sm:pb-14 md:pb-20 lg:pb-24">
      <!-- Fondo base -->
      <div class="absolute inset-0 bg-slate-50 dark:bg-slate-950"></div>

      <!-- TOP STRIP (NO fixed): para que el navbar blanco se lea -->
      <div
        class="pointer-events-none absolute inset-x-0 top-0 z-10
        h-16 sm:h-20 md:h-24
        bg-gradient-to-b from-slate-950/75 via-slate-950/40 to-transparent
        dark:from-black/65 dark:via-black/35"
      />

      <!-- Blobs decorativos -->
      <div class="pointer-events-none absolute -top-28 -left-28 h-[26rem] w-[26rem] rounded-full bg-sky-200/60 dark:bg-sky-500/15" />
      <div class="pointer-events-none absolute -bottom-32 -right-32 h-[30rem] w-[30rem] rounded-full bg-indigo-200/60 dark:bg-indigo-500/15" />

      <!-- Capa de luz (más suave arriba para NO “apagar” el strip) -->
      <div
        class="pointer-events-none absolute inset-0 z-0
        bg-gradient-to-b from-white/40 via-transparent to-white/60
        dark:from-white/5 dark:to-white/5"
      />

      <Container>
        <article
          class="relative z-20 w-full rounded-3xl border border-slate-200/70 bg-white/80
                 shadow-[0_20px_60px_-35px_rgba(0,0,0,0.35)]
                 backdrop-blur-sm
                 dark:border-white/10 dark:bg-slate-900/50"
        >
          <!-- Header -->
          <header class="px-5 pt-7 sm:px-8 sm:pt-9 md:px-10 md:pt-10">
            <h1 class="text-center text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
              Términos y Condiciones
            </h1>

            <div class="mt-3 flex items-center justify-center gap-3" aria-hidden="true">
              <span class="h-px w-10 bg-slate-200 dark:bg-white/10" />
              <span class="h-1 w-10 rounded-full bg-orange-500/90" />
              <span class="h-px w-10 bg-slate-200 dark:bg-white/10" />
            </div>
          </header>

          <!-- Contenido -->
          <div class="px-5 pb-7 pt-7 sm:px-8 sm:pb-9 sm:pt-8 md:px-10 md:pb-10">
            <div
              class="rounded-2xl border border-slate-200/70 bg-white/70
                     p-5 sm:p-6 md:p-7
                     dark:border-white/10 dark:bg-slate-950/20"
            >
              <div class="space-y-5 sm:space-y-6">
                <h2 class="text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Responsable
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  El presente documento establece los términos y condiciones mediante los cuales se regirá el uso de la “APLICACIÓN” Móvil y Página Web
                  de “Mr. Lana” desarrollada por la sociedad (“PRODUCTOS Y SERVICIOS MR LANA”, SOCIEDAD ANÓNIMA PROMOTORA DE INVERSIÓN DE CAPITAL
                  VARIABLE) en lo sucesivo la “APLICACIÓN”.
                </p>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  El “USUARIO” se compromete a leer los términos y condiciones aquí establecidos, previamente a la aceptación de los términos y
                  condiciones de la presente “APLICACIÓN”, por tanto, se entiende que cuenta con el conocimiento integral de este documento y la
                  consecuente aceptación de la totalidad de sus estipulaciones.
                </p>

                <p
                  class="text-sm sm:text-base leading-relaxed text-justify [text-align-last:left]
                         text-slate-700 dark:text-white/80"
                >
                  LEA ESTOS TÉRMINOS Y CONDICIONES DETENIDAMENTE ANTES DE ACCEDER A LA “APLICACIÓN” Y A USAR Y/O ACEPTAR LOS SERVICIOS. CUALQUIER PERSONA
                  HUMANA Y/O JURÍDICA QUE NO ACEPTE ESTOS TÉRMINOS Y CONDICIONES COMO LAS POLÍTICAS DE PRIVACIDAD, LOS CUALES TIENEN UN CARÁCTER
                  OBLIGATORIO Y VINCULANTE, DEBERÁ ABSTENERSE DE ACCEDER Y UTILIZAR LA “APLICACIÓN” COMO ASÍ TAMPOCO PODRÁ CONTRATAR LOS SERVICIOS
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Sistema Aplicativo
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  El “USUARIO” reconoce y acepta en cumplir con todos los términos y condiciones aplicables respecto a la obtención, descarga y
                  actualización de la “APLICACIÓN” que las empresas conocidas como Apple o Google, respectivamente en sus tiendas de aplicaciones,
                  determinen.
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Modificación del Sistema Aplicativo
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  La “APLICACIÓN” se reserva la posibilidad de modificar unilateralmente en cualquier momento y sin previo aviso el diseño, presentación,
                  configuración y/o los términos y condiciones de la “APLICACIÓN”, así como algunas o todas las funcionalidades y/o añadir
                  funcionalidades nuevas. Asimismo, la “APLICACIÓN” se reserva el derecho de modificar o cambiar los presentes términos y condiciones con
                  el objeto de adecuarlo a la legislación vigente aplicable en cada momento, a las novedades jurisprudenciales y a las prácticas
                  habituales de mercado. En este sentido, es responsabilidad del “USUARIO” acceder a los términos periódicamente para estar al corriente
                  de las actualizaciones.
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Información dentro de Dispositivos
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Cuando el “USUARIO” descarga la “APLICACIÓN”, ésta puede solicitar al “USUARIO” permiso para acceder al contenido e información de su
                  dispositivo móvil. La “APLICACIÓN” respetara la privacidad del “USUARIO”, y los permisos que otorgue el “USUARIO” a la “APLICACIÓN”
                  controlarán el modo en el que ésta use, almacene y transfiera dicho contenido e información.
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Servicios
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  La “APLICACIÓN” realiza los servicios de transferencia electrónica, recepción de pagos e identificación de pagos.
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Alcance de los Servicios
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Este Acuerdo no crea ningún contrato de sociedad, de mandato, de franquicia, o relación laboral entre la “APLICACIÓN” y el “USUARIO”.
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Términos y Condiciones del Crédito
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Los “USUARIO”S que soliciten un crédito por medio de la “APLICACIÓN” estarán bajo los criterios y condiciones que se plasmen en el
                  contrato respectivo, el cual se le hará llegar de forma física al momento de su celebración, mismo que se firmará de forma autógrafa
                  de conformidad con los términos y condiciones, manifestando su entera satisfacción relativa a dicha operación, así como al manejo de su
                  información conforme al aviso de privacidad correspondiente.
                </p>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  En lo sucesivo se considera a la “APLICACIÓN” “Mr. Lana” desarrollada por la sociedad (“PRODUCTOS Y SERVICIOS MR LANA”, SOCIEDAD
                  ANÓNIMA
                </p>

                <!-- Continúa pegando el resto aquí con el mismo patrón -->
              </div>
            </div>
          </div>
        </article>
      </Container>
    </section>
  </PublicLayout>
</template>
