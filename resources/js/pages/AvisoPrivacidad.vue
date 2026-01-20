<!-- resources/js/Pages/Privacy/Index.vue -->
<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import Container from '@/components/ui/Container.vue'

const title = 'Aviso de Privacidad | Mr Lana'
const description =
  'Aviso de Privacidad de Mr Lana. Conoce cómo se recaban y tratan los datos personales, limitaciones de uso y divulgación, derechos ARCO, transferencias y comunicación.'
const canonical = 'https://mr-lana.com/aviso-de-privacidad'
const ogImage = 'https://mr-lana.com/img/og/aviso-privacidad.png' // Ajusta si ya tienes uno

const jsonLd = {
  '@context': 'https://schema.org',
  '@type': 'WebPage',
  name: 'Aviso de Privacidad',
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

    <!-- JSON-LD (sin <script> en template) -->
    <meta type="application/ld+json" :content="JSON.stringify(jsonLd)" />
    </Head>

  <PublicLayout>
    <section class="relative overflow-hidden pt-20 sm:pt-24 md:pt-28 pb-10 sm:pb-14 md:pb-20 lg:pb-24">
      <!-- Fondo base -->
      <div class="absolute inset-0 bg-slate-50 dark:bg-slate-950"></div>

      <!-- Blobs decorativos -->
      <div class="pointer-events-none absolute -top-28 -left-28 h-[26rem] w-[26rem] rounded-full bg-sky-200/60 dark:bg-sky-500/15" />
      <div class="pointer-events-none absolute -bottom-32 -right-32 h-[30rem] w-[30rem] rounded-full bg-indigo-200/60 dark:bg-indigo-500/15" />
      <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-white/70 via-transparent to-white/60 dark:from-white/5 dark:to-white/5" />

      <Container>
        <article
          class="relative w-full rounded-3xl border border-slate-200/70 bg-white/80
                 shadow-[0_20px_60px_-35px_rgba(0,0,0,0.35)]
                 backdrop-blur-sm
                 dark:border-white/10 dark:bg-slate-900/50"
        >
          <!-- Header -->
          <header class="px-5 pt-7 sm:px-8 sm:pt-9 md:px-10 md:pt-10">
            <h1 class="text-center text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
              Aviso de Privacidad
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
              <!-- Tipografía y justificado -->
              <div class="space-y-5 sm:space-y-6">
                <p
                  class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]"
                >
                  <span class="font-extrabold text-emerald-700 dark:text-emerald-300">
                    PRODUCTOS Y SERVICIOS MR.LANA S.A.P.I. de C.V.,
                  </span>
                  operando bajo el nombre comercial de
                  <span class="font-extrabold text-emerald-700 dark:text-emerald-300">
                    Mr.Lana
                  </span>
                  , con domicilio en Nueva Italia 5, Col. Lomas de la Selva, Cuernavaca, Morelos, C.P. 62270 en cumplimiento a la Ley Federal de
                  Protección de Datos Personales en Posesión de Particulares (La Ley) y su reglamento, hacen de su conocimiento que recaba y trata sus
                  datos personales para finalidades que establece este Aviso Privacidad.
                </p>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Mr. Lana recaba sus datos personales de manera directa por medios electrónicos ya sea a través del chat o por correo electrónico y/o por
                  teléfono, y de manera indirecta por medio de transferencias que le hacen llegar sus empresas filiales y/o terceros.
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Limitaciones en el Uso y Divulgación de los Datos
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Los datos obtenidos se manejan mediante medios técnicos, administrativos y digitales adecuados para salvaguardar su información.
                  Mantenemos los datos de nuestros clientes durante el tiempo necesario y razonable, considerando las disposiciones legales aplicables.
                  Productos y Servicios Mr. Lana S.A.P.I. de C.V. podrá transferir los datos personales que se encuentren en sus bases de datos a las
                  empresas controladoras de la misma y/o a sus empresas filiales y/o subsidiarias, a menos que los titulares respectivos manifiesten
                  expresamente su oposición, conforme a lo dispuesto por la Ley Federal de Protección de Datos Personales en Posesión de los Particulares
                  (la Ley).
                </p>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Su información personal será utilizada exclusivamente para dar seguimiento a comentarios, consultas, quejas y reclamaciones que usted
                  presente en relación con nuestros productos y servicios, mantener controles estadísticos y administrativos y, en su caso, para ﬁnes de
                  publicidad y prospección comercial. En caso que usted no desee que trate sus datos personales para recibir publicidad y ofertas, usted
                  nos lo puede hacer saber a nuestro Departamento de Atención de Clientes al Tel. ( 777) 422 5973, de lunes a viernes (días
                  hábiles) de 9:00 a 19:00 hrs., o a través del correo electrónico atencionclientes@mr-lana.com
                </p>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  En pleno cumplimiento con las regulaciones de protección de datos, se detalla de manera exhaustiva cómo nuestra aplicación no accede,
                  recoge, utiliza, ni comparte los datos del usuario:
                </p>

                <ol class="list-decimal space-y-3 pl-5 text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed">
                  <li class="text-justify [text-align-last:left]">
                    Tipos de datos de usuario personales y sensibles: Nuestra aplicación no accede, recoge, utiliza, ni comparte datos personales o
                    sensibles de los usuarios. No se solicitan ni se almacenan nombres, direcciones de correo electrónico u otra información personal
                    sensible.
                  </li>
                  <li class="text-justify [text-align-last:left]">
                    Procedimientos seguros para el tratamiento de datos: Aunque no se recogen datos de usuario, mantenemos medidas de seguridad robustas
                    en nuestros sistemas para proteger la privacidad de los usuarios en caso de cualquier información que quede expuesta accidentalmente.
                  </li>
                  <li class="text-justify [text-align-last:left]">
                    Política de conservación y eliminación de datos: Dado que nuestra aplicación no recoge datos de usuario, no existe una política de
                    conservación de datos. En caso de cualquier información ingresada por error, los usuarios pueden eliminar los datos y toda la
                    información asociada en cualquier momento.
                  </li>
                </ol>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Nos comprometemos a mantener la privacidad y seguridad de los usuarios como una prioridad fundamental, y a cumplir con las leyes y
                  regulaciones aplicables en materia de protección de datos.
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Medios para Ejercer los Derechos
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Los titulares podrán ejercer los derechos de acceso, rectificación, cancelación u oposición (ARCO) que les confiere la Ley a partir del
                  6 de enero de 2012, mediante una solicitud por escrito al Departamento de Protección de Datos Personales de Productos y Servicios Mr.
                  Lana S.A.P.I. de C.V., ya sea en la oficina matriz o a través del correo electrónico: atencionclientes@mr-lana.com. Todas las solicitudes
                  dirigidas a Productos y Servicios Mr. Lana S.A.P.I. de C.V., independientemente del medio utilizado por los titulares, deberán incluir
                  lo siguiente: el nombre y firma autógrafa del titular, así como un domicilio u otro medio para comunicarle la respuesta a su solicitud;
                  documentos oficiales que acrediten la identidad del titular; una descripción clara y precisa de los datos personales respecto de los
                  cuales se ejercitarán los derechos que les confiere la Ley; y cualquier elemento o documento que facilite la localización de los datos
                  personales en cuestión.
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Transferencia de Datos
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Nuestros clientes confían en que sus datos no serán transferidos a terceros sin su expreso consentimiento, excepto en los casos
                  señalados en el presente Aviso de Privacidad, en el contrato de prestación de servicios correspondiente o si el cliente adquiere otro
                  producto y/o servicio a través de Productos y Servicios Mr. Lana S.A.P.I. de C.V., así como en los supuestos establecidos en el artículo
                  37 de la Ley.
                </p>

                <h2 class="pt-2 text-base sm:text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Comunicación
                </h2>

                <p class="text-sm sm:text-base text-slate-700 dark:text-white/80 leading-relaxed text-justify [text-align-last:left]">
                  Productos y Servicios Mr. Lana S.A.P.I. de C.V. se reserva el derecho de cambiar, modificar, completar y/o alterar el presente aviso en
                  cualquier momento. En caso de tales modificaciones, se informará a los interesados a través de los medios establecidos por la
                  legislación correspondiente.
                </p>
              </div>
            </div>
          </div>
        </article>
      </Container>
    </section>
  </PublicLayout>
</template>
