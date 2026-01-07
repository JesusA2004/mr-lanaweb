<script setup lang="ts">
    import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue'
    import PrimaryCTA from '@/components/home/PrimaryCTA.vue'
    import NavLinks from '@/components/navigation/NavLinks.vue'
    import Logo from '@/components/ui/Logo.vue'

    type Tone = 'white' | 'accent' | 'muted'

    export type TextPart = {
      text: string
      tone?: Tone
      bold?: boolean
      breakAfter?: boolean
    }

    export type Slide = {
      id: string
      desktopSrc: string
      mobileSrc: string
      alt?: string
      overlay?: {
        titleParts?: TextPart[]
        subtitleParts?: TextPart[]
        titleHtml?: string
        subtitleHtml?: string
        ctaLabel: string
        ctaHref: string
      }
    }

    const props = defineProps<{
      slides: Slide[]
      autoplayMs?: number
      pauseAfterInteractMs?: number
    }>()

    const slidesSafe = computed(() => props.slides ?? [])
    const count = computed(() => slidesSafe.value.length || 1)

    const autoplayMs = computed(() => props.autoplayMs ?? 9000)
    const pauseAfterInteractMs = computed(() => props.pauseAfterInteractMs ?? 8000)

    const index = ref(0)
    const allowAuto = ref(true)

    let timer: number | null = null
    let interactLockTimer: number | null = null

    const current = computed(() => slidesSafe.value[index.value])

    function normalize(i: number) {
      const len = count.value
      return ((i % len) + len) % len
    }

    function stop() {
      if (timer) {
        window.clearInterval(timer)
        timer = null
      }
    }

    function start() {
      stop()
      if (count.value <= 1) return

      timer = window.setInterval(() => {
        if (!allowAuto.value) return
        index.value = normalize(index.value + 1)
      }, autoplayMs.value)
    }

    function lockAutoplayTemporarily() {
      allowAuto.value = false
      if (interactLockTimer) window.clearTimeout(interactLockTimer)
      interactLockTimer = window.setTimeout(() => {
        allowAuto.value = true
      }, pauseAfterInteractMs.value)
    }

    function go(i: number, fromUser = false) {
      index.value = normalize(i)
      if (fromUser) {
        lockAutoplayTemporarily()
        start()
      }
    }

    onMounted(start)

    onBeforeUnmount(() => {
      stop()
      if (interactLockTimer) window.clearTimeout(interactLockTimer)
    })

    watch(
      () => slidesSafe.value.length,
      () => {
        index.value = 0
        allowAuto.value = true
        if (interactLockTimer) window.clearTimeout(interactLockTimer)
        start()
      }
    )

    function toneClass(tone?: Tone) {
      if (tone === 'accent') return 'text-emerald-300'
      if (tone === 'muted') return 'text-white/85'
      return 'text-white'
    }
    </script>

    <template>
      <!-- FULL BLEED real (sin “gaps” laterales) -->
      <section class="relative left-1/2 w-screen -translate-x-1/2">
        <!--  En móvil el Navbar externo es fixed => damos espacio solo aquí -->
        <div class="pt-16 md:pt-0">
          <div class="relative w-full overflow-hidden">
            <!-- Alturas -->
            <div class="relative h-[300px] sm:h-[460px] lg:h-[560px]">
              <!-- NAVBAR DENTRO DEL HERO: SOLO md+ -->
              <div class="absolute inset-x-0 top-0 z-40 hidden md:block">
                <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-4 sm:px-6">
                  <!-- Logo grande dentro del slider -->
                  <Logo />

                  <div class="flex items-center gap-6">
                    <NavLinks />

                    <a
                      href="/bolsa-de-trabajo"
                      class="rounded-full bg-black px-5 py-2 text-sm font-extrabold text-white shadow
                             transition hover:bg-black/90 hover:scale-[1.02] active:scale-[0.98]"
                    >
                      Bolsa de trabajo
                    </a>
                  </div>
                </div>
              </div>

              <!-- TRACK -->
              <div
                class="absolute inset-0 flex h-full w-full transition-transform duration-900 ease-in-out"
                :style="{ transform: `translateX(-${index * 100}%)` }"
              >
                <div
                  v-for="s in slidesSafe"
                  :key="s.id"
                  class="relative h-full w-full flex-none"
                >
                  <!--  CERO franjas: object-cover (full-bleed) -->
                  <picture class="block h-full w-full">
                    <source :srcset="s.mobileSrc" media="(max-width: 768px)" />
                    <img
                      :src="s.desktopSrc"
                      :alt="s.alt ?? 'Mr Lana'"
                      class="h-full w-full object-cover"
                      loading="eager"
                      draggable="false"
                    />
                  </picture>
                </div>
              </div>

              <!-- OVERLAY desktop/tablet (sm+) -->
              <div
                v-if="current?.overlay"
                class="pointer-events-none absolute right-6 top-24 z-30 hidden sm:block
                       w-[440px] max-w-[46vw] lg:w-[560px] lg:max-w-[44vw]"
              >
                <div class="pointer-events-auto rounded-3xl bg-black/35 p-7 lg:p-9 shadow-[0_18px_40px_rgba(0,0,0,0.30)]">
                  <!-- Title -->
                  <h3 class="text-2xl lg:text-3xl font-extrabold leading-tight">
                    <template v-if="current.overlay.titleParts?.length">
                      <template v-for="(p, idx) in current.overlay.titleParts" :key="idx">
                        <span :class="[toneClass(p.tone), p.bold ? 'font-extrabold' : 'font-semibold']">
                          {{ p.text }}
                        </span>
                        <br v-if="p.breakAfter" />
                      </template>
                    </template>
                    <template v-else-if="current.overlay.titleHtml">
                      <span class="text-white" v-html="current.overlay.titleHtml"></span>
                    </template>
                  </h3>

                  <!-- Subtitle -->
                  <p
                    v-if="current.overlay.subtitleParts?.length || current.overlay.subtitleHtml"
                    class="mt-2 text-base lg:text-lg font-semibold"
                  >
                    <template v-if="current.overlay.subtitleParts?.length">
                      <template v-for="(p, idx) in current.overlay.subtitleParts" :key="idx">
                        <span :class="[toneClass(p.tone), p.bold ? 'font-semibold' : 'font-medium']">
                          {{ p.text }}
                        </span>
                        <br v-if="p.breakAfter" />
                      </template>
                    </template>
                    <template v-else>
                      <span class="text-white/90" v-html="current.overlay.subtitleHtml"></span>
                    </template>
                  </p>

                  <!-- CTA grande -->
                  <div class="mt-6 flex justify-center">
                    <PrimaryCTA :href="current.overlay.ctaHref" :label="current.overlay.ctaLabel" size="lg" />
                  </div>
                </div>
              </div>

              <!-- OVERLAY móvil (abajo y compacto) -->
              <div v-if="current?.overlay" class="pointer-events-none absolute inset-x-4 bottom-10 z-30 sm:hidden">
                <div class="pointer-events-auto mx-auto max-w-[92vw] rounded-3xl bg-black/35 p-4 shadow-[0_18px_40px_rgba(0,0,0,0.30)]">
                  <h3 class="text-base font-extrabold leading-snug">
                    <template v-if="current.overlay.titleParts?.length">
                      <template v-for="(p, idx) in current.overlay.titleParts" :key="idx">
                        <span :class="[toneClass(p.tone), p.bold ? 'font-extrabold' : 'font-semibold']">
                          {{ p.text }}
                        </span>
                        <br v-if="p.breakAfter" />
                      </template>
                    </template>
                    <template v-else-if="current.overlay.titleHtml">
                      <span class="text-white" v-html="current.overlay.titleHtml"></span>
                    </template>
                  </h3>

                  <p v-if="current.overlay.subtitleParts?.length || current.overlay.subtitleHtml" class="mt-1 text-xs font-semibold">
                    <template v-if="current.overlay.subtitleParts?.length">
                      <template v-for="(p, idx) in current.overlay.subtitleParts" :key="idx">
                        <span :class="[toneClass(p.tone), p.bold ? 'font-semibold' : 'font-medium']">
                          {{ p.text }}
                        </span>
                        <br v-if="p.breakAfter" />
                      </template>
                    </template>
                    <template v-else>
                      <span class="text-white/90" v-html="current.overlay.subtitleHtml"></span>
                    </template>
                  </p>

                  <div class="mt-3 flex justify-center">
                    <PrimaryCTA :href="current.overlay.ctaHref" :label="current.overlay.ctaLabel" size="sm" />
                  </div>
                </div>
              </div>

              <!-- DOTS -->
              <div class="absolute bottom-4 left-0 right-0 z-40 flex justify-center gap-2">
                <button
                  v-for="(s, i) in slidesSafe"
                  :key="s.id"
                  type="button"
                  class="h-3 w-3 rounded-full ring-1 ring-black/10 transition hover:scale-110"
                  :class="i === index ? 'bg-black/70' : 'bg-white/80 hover:bg-white'"
                  @click="go(i, true)"
                  :aria-label="`Ir a slide ${i + 1}`"
                />
              </div>
            </div>

            <!-- separación con lo de abajo -->
            <div class="h-6 sm:h-8"></div>
          </div>
        </div>
      </section>
    </template>
