<!-- resources/js/Pages/Faqs/Index.vue -->
<script setup lang="ts">
    /**
     * Página pública de FAQs (full width real)
     * ---------------------------------------
     * Objetivo:
     * - Layout tipo referencia: acordeón izquierda + formulario derecha.
     * - Aprovechar el ancho total de la pantalla (sin max-width cap).
     * - Dejar espacio superior para un navbar “pequeño”.
     *
     * Puntos clave:
     * - Se usa Container "fluid" (sin max-w-7xl).
     * - Card principal ocupa todo el ancho disponible.
     * - Padding lateral mínimo y escalable por breakpoint.
     */

    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import Container from '@/components/ui/Container.vue'
    import FaqAccordion from '@/components/faq/FaqAccordion.vue'
    import { faqs } from '@/data/faqs'
    </script>

    <template>
      <Head title="FAQs" />

      <PublicLayout>
        <!--
          Separación superior:
          - Esto evita que el navbar se “coma” el inicio del contenido.
          - Ajusta si tu header es más alto/bajo.
        -->
        <section class="relative overflow-hidden pt-20 sm:pt-24 md:pt-28 pb-10 sm:pb-14 md:pb-20 lg:pb-24">
          <!-- Fondo base -->
          <div class="absolute inset-0 bg-slate-50 dark:bg-slate-950"></div>

          <!-- Blobs decorativos (look de la referencia, sin blur pesado) -->
          <div class="pointer-events-none absolute -top-28 -left-28 h-[26rem] w-[26rem] rounded-full bg-sky-200/60 dark:bg-sky-500/15" />
          <div class="pointer-events-none absolute -bottom-32 -right-32 h-[30rem] w-[30rem] rounded-full bg-indigo-200/60 dark:bg-indigo-500/15" />
          <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-white/70 via-transparent to-white/60 dark:from-white/5 dark:to-white/5" />

          <!--
            Container fluid:
            - No max width fijo.
            - Padding lateral pequeño para no desperdiciar espacio.
          -->
          <Container>
            <!--
              Card principal:
              - Full width (w-full)
              - Radio grande y border suave para look premium
              - Sin max-w “capado” para que use toda la pantalla
            -->
            <div
              class="relative w-full rounded-3xl border border-slate-200/70 bg-white/80
                     shadow-[0_20px_60px_-35px_rgba(0,0,0,0.35)]
                     backdrop-blur-sm
                     dark:border-white/10 dark:bg-slate-900/50"
            >
              <!-- Header -->
              <div class="px-5 pt-7 sm:px-8 sm:pt-9 md:px-10 md:pt-10">
                <h1 class="text-center text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                  Preguntas frecuentes (FAQ)
                </h1>

                <div class="mt-3 flex items-center justify-center gap-3">
                  <span class="h-px w-10 bg-slate-200 dark:bg-white/10" />
                  <span class="h-1 w-10 rounded-full bg-orange-500/90" />
                  <span class="h-px w-10 bg-slate-200 dark:bg-white/10" />
                </div>

                <p class="mx-auto mt-4 max-w-3xl text-center text-sm sm:text-base text-slate-600 dark:text-white/70">
                  Encuentra respuestas rápidas. Si algo no cuadra, levanta tu pregunta y lo resolvemos.
                </p>
              </div>

              <!--
                Grid principal:
                - En mobile: 1 columna
                - En desktop: 2 columnas con proporción real (acordeón más ancho)
                - En 2xl: aún más espacio para el acordeón (como referencia)
              -->
              <div
                class="grid gap-6 px-5 pb-7 pt-7 sm:px-8 sm:pb-9 sm:pt-8 md:px-10 md:pb-10
                       lg:grid-cols-12 lg:gap-8"
              >
                <!-- Columna izquierda (FAQ) -->
                <div class="min-w-0 lg:col-span-7 xl:col-span-8">
                  <FaqAccordion :items="faqs" />
                </div>

                <!-- Columna derecha (Formulario) -->
                <div class="min-w-0 lg:col-span-5 xl:col-span-4">
                  <div
                    class="rounded-2xl border border-slate-200/70 bg-white/70 p-5 sm:p-6
                           shadow-sm
                           dark:border-white/10 dark:bg-slate-950/20"
                  >
                    <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white">
                      Haz tu pregunta
                    </h2>

                    <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-white/70">
                      Déjanos tus datos y una descripción corta. El equipo te responde.
                    </p>

                    <!-- UI-only: conéctalo después con useForm() + endpoint -->
                    <form class="mt-5 space-y-3" @submit.prevent>
                      <div>
                        <label class="sr-only" for="faq_name">Name</label>
                        <input
                          id="faq_name"
                          type="text"
                          placeholder="Nombre"
                          class="h-11 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm text-slate-900
                                 placeholder:text-slate-400 shadow-sm outline-none
                                 focus:border-orange-400 focus:ring-2 focus:ring-orange-200
                                 dark:border-white/10 dark:bg-slate-900/40 dark:text-white dark:placeholder:text-white/40
                                 dark:focus:border-orange-300 dark:focus:ring-orange-500/20"
                        />
                      </div>

                      <div>
                        <label class="sr-only" for="faq_email">Email</label>
                        <input
                          id="faq_email"
                          type="email"
                          placeholder="Correo electrónico"
                          class="h-11 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm text-slate-900
                                 placeholder:text-slate-400 shadow-sm outline-none
                                 focus:border-orange-400 focus:ring-2 focus:ring-orange-200
                                 dark:border-white/10 dark:bg-slate-900/40 dark:text-white dark:placeholder:text-white/40
                                 dark:focus:border-orange-300 dark:focus:ring-orange-500/20"
                        />
                      </div>

                      <div>
                        <label class="sr-only" for="faq_msg">Write Something</label>
                        <textarea
                          id="faq_msg"
                          rows="4"
                          placeholder="Escribe tu pregunta"
                          class="w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900
                                 placeholder:text-slate-400 shadow-sm outline-none
                                 focus:border-orange-400 focus:ring-2 focus:ring-orange-200
                                 dark:border-white/10 dark:bg-slate-900/40 dark:text-white dark:placeholder:text-white/40
                                 dark:focus:border-orange-300 dark:focus:ring-orange-500/20"
                        />
                      </div>

                      <button
                        type="submit"
                        class="inline-flex h-11 w-fit items-center justify-center rounded-xl bg-orange-600 px-5
                               text-xs font-extrabold tracking-wide text-white shadow-sm
                               transition hover:bg-orange-500 active:translate-y-[1px]
                               focus:outline-none focus:ring-2 focus:ring-orange-300 focus:ring-offset-2
                               dark:focus:ring-offset-slate-950"
                      >
                        Enviar pregunta
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </Container>
        </section>
      </PublicLayout>
    </template>
