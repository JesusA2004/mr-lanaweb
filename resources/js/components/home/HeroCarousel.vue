<script setup lang="ts">
    import { computed, onMounted, onUnmounted, ref } from 'vue'
    import type { Slide } from '@/data/slides'
    import PrimaryCTA from './PrimaryCTA.vue'
    
    const props = defineProps<{
      slides: Slide[]
      intervalMs?: number
    }>()
    
    const idx = ref(0)
    const total = computed(() => props.slides.length)
    let timer: number | undefined
    
    function next() {
      if (!total.value) return
      idx.value = (idx.value + 1) % total.value
    }
    function prev() {
      if (!total.value) return
      idx.value = (idx.value - 1 + total.value) % total.value
    }
    
    onMounted(() => {
      const ms = props.intervalMs ?? 6000
      if (total.value > 1) timer = window.setInterval(next, ms)
    })
    onUnmounted(() => {
      if (timer) window.clearInterval(timer)
    })
    
    const slide = computed(() => props.slides[idx.value])
    </script>
    
    <template>
      <section class="relative">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
          <div class="grid items-center gap-10 md:grid-cols-2">
            <div>
              <p class="inline-flex rounded-full bg-white/70 px-4 py-1 text-sm font-semibold text-[#106A59] border border-white">
                MR-Lana
              </p>
    
              <h1 class="mt-5 text-4xl font-bold tracking-tight text-slate-900 md:text-5xl">
                {{ slide?.title }}
              </h1>
    
              <p class="mt-4 text-lg text-slate-700">
                {{ slide?.subtitle }}
              </p>
    
              <div class="mt-8 flex flex-wrap items-center gap-3">
                <PrimaryCTA :href="slide?.ctaHref" :label="slide?.ctaLabel" />
                <a href="/sucursales" class="rounded-2xl border border-slate-200 bg-white px-6 py-4 text-base font-semibold text-slate-900 hover:bg-slate-50 transition">
                  Ver sucursales
                </a>
              </div>
    
              <div v-if="total > 1" class="mt-8 flex items-center gap-3">
                <button type="button" class="rounded-xl border bg-white px-3 py-2 hover:bg-slate-50" @click="prev">←</button>
                <button type="button" class="rounded-xl border bg-white px-3 py-2 hover:bg-slate-50" @click="next">→</button>
                <div class="text-sm text-slate-600">
                  {{ idx + 1 }} / {{ total }}
                </div>
              </div>
            </div>
    
            <div class="relative">
              <div class="aspect-[4/3] w-full overflow-hidden rounded-3xl border border-white/50 bg-white shadow-sm">
                <img
                  v-if="slide?.image"
                  :src="slide.image"
                  alt=""
                  class="h-full w-full object-cover"
                  loading="lazy"
                  decoding="async"
                />
                <div v-else class="h-full w-full bg-gradient-to-br from-[#C2F6EC] to-white"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </template>
    