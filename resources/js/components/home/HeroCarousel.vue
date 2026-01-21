<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'
import type { Slide } from '@/data/homeSlides'
import PrimaryCTA from '@/components/home/PrimaryCTA.vue'

const props = withDefaults(
  defineProps<{
    slides: Slide[]
    autoplayMs?: number
    pauseAfterInteractMs?: number
  }>(),
  { autoplayMs: 9000, pauseAfterInteractMs: 8000 }
)

const slides = computed(() => props.slides || [])
const idx = ref(0)

let timer: number | null = null
let resumeTimer: number | null = null

const clamp = (n: number) => {
  const len = slides.value.length
  if (!len) return 0
  return ((n % len) + len) % len
}

const start = () => {
  if (timer) window.clearInterval(timer)
  if (!slides.value.length) return
  timer = window.setInterval(() => (idx.value = clamp(idx.value + 1)), props.autoplayMs)
}

const pauseAndResume = () => {
  if (timer) window.clearInterval(timer)
  if (resumeTimer) window.clearTimeout(resumeTimer)
  resumeTimer = window.setTimeout(start, props.pauseAfterInteractMs)
}

const go = (n: number) => {
  idx.value = clamp(n)
  pauseAndResume()
}
const next = () => go(idx.value + 1)
const prev = () => go(idx.value - 1)

onMounted(start)
onBeforeUnmount(() => {
  if (timer) window.clearInterval(timer)
  if (resumeTimer) window.clearTimeout(resumeTimer)
})

// Swipe
const touchX = ref<number | null>(null)
const onTouchStart = (e: TouchEvent) => (touchX.value = e.touches[0]?.clientX ?? null)
const onTouchEnd = (e: TouchEvent) => {
  const startX = touchX.value
  const endX = e.changedTouches[0]?.clientX ?? null
  touchX.value = null
  if (startX == null || endX == null) return
  const dx = endX - startX
  if (Math.abs(dx) < 35) return
  dx < 0 ? next() : prev()
}

const objectPos = (_slideId: string) => 'center'
</script>

<template>
  <section
    class="relative w-full overflow-hidden"
    @touchstart.passive="onTouchStart"
    @touchend.passive="onTouchEnd"
  >
    <div class="relative">
      <!-- TRACK -->
      <div
        class="flex w-full transition-transform duration-500 ease-out will-change-transform"
        :style="{ transform: `translateX(-${idx * 100}%)` }"
      >
        <div v-for="s in slides" :key="s.id" class="relative w-full shrink-0">
          <div class="relative w-full overflow-hidden">
            <!-- IMAGEN -->
            <div class="relative w-full h-auto">
              <picture class="block w-full">
                <source media="(min-width: 1280px)" :srcset="s.desktopSrc" />
                <img
                  :src="s.mobileSrc"
                  :alt="s.alt"
                  class="block w-full h-auto object-contain"
                  :style="{ objectPosition: objectPos(s.id) }"
                  draggable="false"
                />
              </picture>
            </div>

            <!-- OVERLAY OSCURO (NUEVO): debajo del CTA/navbar, encima de la imagen -->
            <!-- Solo desktop (md+) para que NO afecte mobile -->
            <div
              class="pointer-events-none absolute inset-0 z-10 hidden md:block
                     bg-gradient-to-b from-black/35 via-black/20 to-black/35"
            />

            <!-- OVERLAY DESKTOP (CTA) -->
            <div class="absolute inset-0 z-20 hidden md:flex items-start">
              <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 pt-0">
                <!-- CTA derecha -->
                <div class="mt-20 max-w-[560px] lg:mt-20">
                  <div
                    class="animate-in fade-in duration-500
                           slide-in-from-bottom-6 translate-x-50
                           md:translate-x-95
                           md:translate-y-40 lg:translate-y-55
                           lg:translate-x-120
                           2xl:translate-x-200
                           2xl:translate-y-80
                           origin-top-right"
                  >
                    <PrimaryCTA :overlay="s.overlay" />
                  </div>
                </div>
              </div>
            </div>

            <!-- OVERLAY MOBILE -->
            <div class="absolute inset-0 z-20 md:hidden pointer-events-none">
              <div
                class="absolute inset-x-0 bottom-0 pointer-events-auto px-3
                       [padding-bottom:calc(env(safe-area-inset-bottom)+10px)]"
              >
                <div class="mx-auto w-[min(88vw,220px)]">
                  <PrimaryCTA :overlay="s.overlay" :compact="true" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CONTROLES DESKTOP -->
      <button
        type="button"
        class="absolute left-6 top-1/2 z-30 hidden -translate-y-1/2
               text-black text-5xl font-light transition hover:text-black hover:scale-[1.4]
               active:scale-[0.96] md:block"
        @click="prev"
        aria-label="Anterior"
      >
        ‹
      </button>

      <button
        type="button"
        class="absolute right-6 top-1/2 z-30 hidden -translate-y-1/2
               text-black text-5xl font-light transition hover:text-black hover:scale-[1.4]
               active:scale-[0.96] md:block"
        @click="next"
        aria-label="Siguiente"
      >
        ›
      </button>

      <!-- DOTS -->
      <div
        class="absolute left-0 right-0 z-30 flex items-center justify-center gap-2
               bottom-[calc(env(safe-area-inset-bottom)+8px)] md:bottom-4"
      >
        <button
          v-for="(_, i) in slides"
          :key="`dot-${i}`"
          type="button"
          class="h-2.5 w-2.5 rounded-full transition-all duration-200"
          :class="i === idx ? 'bg-black/70 scale-110' : 'bg-black/25 hover:bg-black/40 hover:scale-105'"
          @click="go(i)"
          :aria-label="`Ir al slide ${i + 1}`"
        />
      </div>
    </div>
  </section>
</template>
