<!-- resources/js/Pages/About/Index.vue -->
<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import Container from '@/components/ui/Container.vue'

const title = '¿Quiénes somos? | Mr Lana'
</script>

<template>
  <Head :title="title" />

  <PublicLayout>
    <!-- ===================== SECCIÓN 1: QUIÉNES SOMOS + PRINCIPIOS ===================== -->
    <section class="relative overflow-hidden pt-20 sm:pt-24 md:pt-28 pb-12 sm:pb-16 md:pb-20">
      <!-- Fondo base -->
      <div class="absolute inset-0 bg-zinc-950"></div>

      <!-- Patrón “punteado” sutil -->
      <div
        class="pointer-events-none absolute inset-0 opacity-30"
        style="
          background-image: radial-gradient(rgba(255,255,255,.18) 1px, transparent 1px);
          background-size: 18px 18px;
        "
      />

      <!-- Blobs suaves -->
      <div class="pointer-events-none absolute -top-32 -left-40 h-[32rem] w-[32rem] rounded-full bg-emerald-500/15 blur-3xl" />
      <div class="pointer-events-none absolute -bottom-40 -right-40 h-[34rem] w-[34rem] rounded-full bg-sky-500/15 blur-3xl" />

      <Container>
        <div
          class="relative w-full overflow-hidden rounded-3xl border border-white/10
                 bg-white/5 shadow-[0_25px_70px_-45px_rgba(0,0,0,0.75)]
                 backdrop-blur-sm"
        >
          <!-- Header / Hero -->
          <div class="px-5 pt-8 sm:px-8 sm:pt-10 md:px-10 md:pt-12">
            <div class="flex items-center justify-center">
              <div class="select-none text-center">
                <div class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                  mr.<span class="text-sky-300">lana</span>
                </div>
                <div class="mx-auto mt-1 h-1 w-16 rounded-full bg-emerald-400/90" />
              </div>
            </div>

            <h1
              class="mt-6 text-center text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white"
              style="text-shadow: 0 3px 0 rgba(34,197,94,.55), 0 10px 30px rgba(0,0,0,.55);"
            >
              ¿QUIÉNES SOMOS?
            </h1>

            <p class="mx-auto mt-5 max-w-4xl text-center text-sm sm:text-base md:text-lg text-white/80 leading-relaxed">
              Mr. Lana es una entidad financiera mexicana de nano y microcréditos que trabaja con compromiso y pasión para ofrecer préstamos rápidos
              a negocios, con el fin de impulsar el crecimiento y desarrollo de proyectos productivos en el país.
            </p>
          </div>

          <!-- PRINCIPIOS -->
          <div class="px-5 pb-10 pt-10 sm:px-8 sm:pb-12 md:px-10 md:pb-14">
            <h2
              class="text-center text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white"
              style="text-shadow: 0 3px 0 rgba(34,197,94,.55), 0 10px 30px rgba(0,0,0,.55);"
            >
              PRINCIPIOS
            </h2>

            <div class="mt-10 grid gap-6 lg:grid-cols-12 lg:gap-8 items-stretch">
              <!-- Izquierda -->
              <div class="lg:col-span-4 space-y-6">
                <!-- Innovación -->
                <div
                  class="relative overflow-hidden rounded-[32px] border-4 border-emerald-400/70 bg-white/5 p-6
                         shadow-[0_18px_50px_-30px_rgba(0,0,0,0.8)]"
                >
                  <div class="flex items-start justify-between gap-4">
                    <div>
                      <h3 class="text-emerald-300 text-lg sm:text-xl font-extrabold">Innovación:</h3>
                      <p class="mt-2 text-sm sm:text-base text-white/80 leading-relaxed">
                        Implementamos nuevas tecnologías y estamos siempre a la vanguardia.
                      </p>
                    </div>

                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-emerald-400/10 ring-1 ring-emerald-300/30">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        class="h-6 w-6 text-emerald-300" fill="none" stroke="currentColor"
                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18h6"/>
                        <path d="M10 22h4"/>
                        <path d="M12 2a7 7 0 0 0-4 12c.4.4.7 1 .8 1.6L9 18h6l.2-2.4c.1-.6.4-1.2.8-1.6A7 7 0 0 0 12 2z"/>
                      </svg>
                    </div>
                  </div>
                </div>

                <!-- Trabajo en equipo -->
                <div
                  class="relative overflow-hidden rounded-[32px] border-4 border-sky-300/70 bg-white/5 p-6
                         shadow-[0_18px_50px_-30px_rgba(0,0,0,0.8)]"
                >
                  <div class="flex items-start justify-between gap-4">
                    <div>
                      <h3 class="text-sky-200 text-lg sm:text-xl font-extrabold">Trabajo en equipo:</h3>
                      <p class="mt-2 text-sm sm:text-base text-white/80 leading-relaxed">
                        Creamos comunidad para alcanzar nuestras metas y la de nuestros clientes.
                      </p>
                    </div>

                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-sky-300/10 ring-1 ring-sky-200/30">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        class="h-6 w-6 text-sky-200" fill="none" stroke="currentColor"
                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="8" r="3"/>
                        <circle cx="16" cy="8" r="3"/>
                        <path d="M2 20c0-3 3-5 6-5"/>
                        <path d="M22 20c0-3-3-5-6-5"/>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Centro -->
              <div class="lg:col-span-4 relative min-h-[240px]">
                <div class="pointer-events-none hidden lg:block absolute inset-0">
                  <div
                    class="absolute left-1/2 top-1/2 h-[340px] w-[340px] -translate-x-1/2 -translate-y-1/2
                           rounded-[48px] bg-gradient-to-br from-emerald-400/20 via-sky-400/10 to-emerald-400/20
                           ring-1 ring-white/10"
                    style="clip-path: path('M 60 40 C 100 10, 240 10, 280 40 C 310 70, 310 270, 280 300 C 240 330, 100 330, 60 300 C 30 270, 30 70, 60 40 Z');"
                  />
                </div>

                <div class="relative mx-auto mt-6 lg:mt-10 grid place-items-center">
                  <div
                    class="grid h-40 w-40 sm:h-44 sm:w-44 place-items-center rounded-[40px]
                           bg-white/5 ring-1 ring-white/10 shadow-[0_25px_70px_-45px_rgba(0,0,0,0.9)]"
                  >
                    <div class="text-center">
                      <div class="text-4xl">🐑</div>
                      <div class="mt-2 text-xs font-bold tracking-widest text-white/70">MR LANA</div>
                    </div>
                  </div>

                  <p class="mt-4 text-center text-xs sm:text-sm text-white/55 max-w-[22rem]">
                    (Aquí puedes colocar tu imagen/mascota real cuando la tengas lista. El layout no se rompe.)
                  </p>
                </div>
              </div>

              <!-- Derecha -->
              <div class="lg:col-span-4 space-y-6">
                <!-- Diligencia -->
                <div
                  class="relative overflow-hidden rounded-[32px] border-4 border-emerald-400/70 bg-white/5 p-6
                         shadow-[0_18px_50px_-30px_rgba(0,0,0,0.8)]"
                >
                  <div class="flex items-start justify-between gap-4">
                    <div>
                      <h3 class="text-emerald-300 text-lg sm:text-xl font-extrabold">Diligencia:</h3>
                      <p class="mt-2 text-sm sm:text-base text-white/80 leading-relaxed">
                        Nos esforzamos día con día para atender de manera eficaz cada uno de nuestros procesos.
                      </p>
                    </div>

                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-emerald-400/10 ring-1 ring-emerald-300/30">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        class="h-6 w-6 text-emerald-300" fill="none" stroke="currentColor"
                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2l2.5 6H21l-5 3.5L18 20l-6-4-6 4 2-8.5L3 8h6.5z"/>
                      </svg>
                    </div>
                  </div>
                </div>

                <!-- Integridad -->
                <div
                  class="relative overflow-hidden rounded-[32px] border-4 border-sky-300/70 bg-white/5 p-6
                         shadow-[0_18px_50px_-30px_rgba(0,0,0,0.8)]"
                >
                  <div class="flex items-start justify-between gap-4">
                    <div>
                      <h3 class="text-sky-200 text-lg sm:text-xl font-extrabold">Integridad:</h3>
                      <p class="mt-2 text-sm sm:text-base text-white/80 leading-relaxed">
                        Somos coherentes en nuestra forma de pensar y actuar. Siempre desde lo correcto y justo.
                      </p>
                    </div>

                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-sky-300/10 ring-1 ring-sky-200/30">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        class="h-6 w-6 text-sky-200" fill="none" stroke="currentColor"
                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2l3 6 7 .6-5.2 4.5 1.6 6.9L12 17l-6.4 3 1.6-6.9L2 8.6 9 8z"/>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- CTA inferior opcional -->
            <div class="mt-10 flex flex-col items-center gap-3">
              <div class="h-px w-24 bg-white/10" />
              <p class="text-center text-xs sm:text-sm text-white/60 max-w-3xl">
                ¿Quieres conocer productos, requisitos o tiempos de respuesta? Ve a <span class="text-emerald-300 font-bold">FAQs</span> o inicia tu solicitud en <span class="text-sky-200 font-bold">Impulsa</span>.
              </p>
              <div class="mt-3 flex flex-wrap items-center justify-center gap-3">
                <a
                  href="/faqs"
                  class="inline-flex h-11 items-center justify-center rounded-xl bg-white/10 px-5
                         text-xs font-extrabold tracking-wide text-white transition
                         hover:bg-white/15 active:translate-y-[1px]
                         ring-1 ring-white/10"
                >
                  Ver FAQs
                </a>
                <a
                  href="/impulsa-tu-negocio"
                  class="inline-flex h-11 items-center justify-center rounded-xl bg-emerald-500/90 px-5
                         text-xs font-extrabold tracking-wide text-black transition
                         hover:bg-emerald-400 active:translate-y-[1px]
                         shadow-[0_18px_50px_-35px_rgba(34,197,94,0.55)]"
                >
                  Impulsa tu negocio
                </a>
              </div>
            </div>
          </div>
        </div>
      </Container>
    </section>

    <!-- ===================== SECCIÓN 2: MISIÓN / VISIÓN (continuación) ===================== -->
    <section class="relative overflow-hidden pb-14 sm:pb-16 md:pb-20">
      <!-- Fondo claro con ondas -->
      <div class="absolute inset-0 bg-slate-50"></div>

      <!-- Onda superior tipo banda (verde/teal) -->
      <div class="pointer-events-none absolute inset-x-0 -top-1 h-44 sm:h-52 md:h-60">
        <div class="h-full w-full bg-gradient-to-r from-emerald-500 via-teal-400 to-sky-400 opacity-90" />
        <div
          class="absolute bottom-0 left-0 h-16 w-full bg-slate-50"
          style="clip-path: ellipse(80% 100% at 50% 0%);"
        />
      </div>

      <!-- Onda inferior (verde/teal) -->
      <div class="pointer-events-none absolute inset-x-0 -bottom-1 h-52 sm:h-60 md:h-72">
        <div
          class="absolute bottom-0 left-0 h-full w-full bg-gradient-to-r from-emerald-500 via-teal-400 to-sky-400 opacity-90"
          style="clip-path: ellipse(85% 70% at 50% 100%);"
        />
      </div>

      <!-- Patrón punteado sutil -->
      <div
        class="pointer-events-none absolute inset-0 opacity-[0.08]"
        style="
          background-image: radial-gradient(rgba(2,6,23,.55) 1px, transparent 1px);
          background-size: 18px 18px;
        "
      />

      <Container>
        <div class="relative pt-24 sm:pt-28 md:pt-32">
          <!-- Mascota + logo (placeholder) -->
          <div class="relative mb-8 flex items-center justify-center">
            <div class="flex items-center gap-3">
              <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <span class="text-2xl">🐑</span>
              </div>
              <div class="text-xl sm:text-2xl font-black tracking-tight text-slate-900">
                mr.<span class="text-emerald-600">lana</span>
              </div>
            </div>
          </div>

          <!-- Cards Misión / Visión -->
          <div class="mx-auto grid max-w-5xl gap-7 sm:gap-8">
            <!-- MISIÓN (izquierda) -->
            <div class="relative">
              <!-- Badge icon -->
              <div class="absolute -left-2 sm:-left-4 top-6 grid h-16 w-16 place-items-center rounded-full bg-white ring-4 ring-emerald-500 shadow-md">
                <div class="grid h-12 w-12 place-items-center rounded-full bg-slate-50 ring-1 ring-slate-200">
                  <!-- Icon target -->
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    class="h-7 w-7 text-emerald-600" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"/>
                    <circle cx="12" cy="12" r="5"/>
                    <circle cx="12" cy="12" r="1.5"/>
                  </svg>
                </div>
              </div>

              <div
                class="rounded-[28px] bg-slate-700 text-white shadow-[0_25px_60px_-40px_rgba(0,0,0,.55)]
                       ring-4 ring-emerald-500/90 px-6 sm:px-8 py-7 sm:py-8"
              >
                <div class="flex items-start justify-between gap-4">
                  <h3 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Misión</h3>

                  <!-- burbujas -->
                  <div class="hidden sm:flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-emerald-300/80 shadow-sm" />
                    <span class="h-4 w-4 rounded-full bg-sky-300/80 shadow-sm" />
                    <span class="h-2.5 w-2.5 rounded-full bg-teal-200/80 shadow-sm" />
                  </div>
                </div>

                <p class="mt-3 text-sm sm:text-base leading-relaxed text-white/90">
                  Satisfacer las necesidades financieras de los clientes a través de
                  <span class="font-extrabold text-emerald-300">préstamos rápidos y confiables</span>,
                  a negocios establecidos y personas con actividad laboral, para
                  <span class="font-extrabold text-emerald-300">impulsar sus proyectos productivos</span>.
                </p>
              </div>
            </div>

            <!-- VISIÓN (derecha) -->
            <div class="relative">
              <!-- Badge icon (derecha) -->
              <div class="absolute -right-2 sm:-right-4 top-6 grid h-16 w-16 place-items-center rounded-full bg-white ring-4 ring-sky-400 shadow-md">
                <div class="grid h-12 w-12 place-items-center rounded-full bg-slate-50 ring-1 ring-slate-200">
                  <!-- Icon bulb -->
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    class="h-7 w-7 text-sky-500" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18h6"/>
                    <path d="M10 22h4"/>
                    <path d="M12 2a7 7 0 0 0-4 12c.4.4.7 1 .8 1.6L9 18h6l.2-2.4c.1-.6.4-1.2.8-1.6A7 7 0 0 0 12 2z"/>
                  </svg>
                </div>
              </div>

              <div
                class="rounded-[28px] bg-slate-700 text-white shadow-[0_25px_60px_-40px_rgba(0,0,0,.55)]
                       ring-4 ring-sky-400/90 px-6 sm:px-8 py-7 sm:py-8"
              >
                <div class="flex items-start justify-between gap-4">
                  <h3 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Visión</h3>

                  <!-- burbujas -->
                  <div class="hidden sm:flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-emerald-300/80 shadow-sm" />
                    <span class="h-4 w-4 rounded-full bg-sky-300/80 shadow-sm" />
                    <span class="h-2.5 w-2.5 rounded-full bg-teal-200/80 shadow-sm" />
                  </div>
                </div>

                <p class="mt-3 text-sm sm:text-base leading-relaxed text-white/90">
                  Consolidarnos y posicionarnos como la entidad financiera número uno en la rama de nano y microcréditos
                  en el mercado nacional e internacional, a través de innovación tecnológica y desarrollo constante de nuestros colaboradores.
                  <span class="font-extrabold text-sky-300">Generando confianza y fidelidad por parte de nuestros clientes</span>.
                </p>
              </div>
            </div>
          </div>

          <!-- separador -->
          <div class="mt-10 flex items-center justify-center">
            <span class="h-px w-28 bg-slate-200" />
          </div>
        </div>
      </Container>
    </section>
  </PublicLayout>
</template>
