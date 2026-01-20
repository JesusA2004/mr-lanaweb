<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'

export type SegmentTabItem<K extends string = string> = {
  key: K
  label: string
  iconSrc?: string
  iconAlt?: string
}

const props = defineProps<{
  modelValue: string
  items: SegmentTabItem[]
  ariaLabel?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

const activeKey = computed(() => props.modelValue)

function setActive(key: string) {
  if (key === props.modelValue) return
  emit('update:modelValue', key)
}

const scrollerRef = ref<HTMLDivElement | null>(null)
const canScrollLeft = ref(false)
const canScrollRight = ref(false)

function updateScrollHints() {
  const el = scrollerRef.value
  if (!el) return
  const max = el.scrollWidth - el.clientWidth
  const left = el.scrollLeft
  canScrollLeft.value = left > 2
  canScrollRight.value = left < max - 2
}

function scrollByDir(dir: 'left' | 'right') {
  const el = scrollerRef.value
  if (!el) return
  const step = Math.max(220, Math.floor(el.clientWidth * 0.6))
  el.scrollBy({ left: dir === 'left' ? -step : step, behavior: 'smooth' })
}

function scrollActiveIntoView() {
  const el = scrollerRef.value
  if (!el) return
  const active = el.querySelector<HTMLElement>('[data-active="true"]')
  if (!active) return
  active.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' })
}

let ro: ResizeObserver | null = null

onMounted(() => {
  const el = scrollerRef.value
  if (!el) return

  updateScrollHints()
  el.addEventListener('scroll', updateScrollHints, { passive: true })

  ro = new ResizeObserver(() => updateScrollHints())
  ro.observe(el)

  window.addEventListener('resize', updateScrollHints, { passive: true })
})

onBeforeUnmount(() => {
  const el = scrollerRef.value
  if (el) el.removeEventListener('scroll', updateScrollHints)
  if (ro && scrollerRef.value) ro.unobserve(scrollerRef.value)
  ro = null
  window.removeEventListener('resize', updateScrollHints)
})

watch(
  () => props.modelValue,
  async () => {
    await nextTick()
    scrollActiveIntoView()
  }
)
</script>

<template>
  <div class="w-full">
    <div class="relative">
      <!-- Contenedor tipo "chips" (blanco, moderno) -->
      <div
        class="w-full rounded-2xl bg-white/95 p-2 shadow-sm ring-1 ring-slate-200"
        role="tablist"
        :aria-label="ariaLabel || 'Pestañas'"
      >
        <!-- Botón izq (solo si hay overflow) -->
        <button
          v-if="canScrollLeft"
          type="button"
          @click="scrollByDir('left')"
          class="absolute left-2 top-1/2 -translate-y-1/2 z-10
                 inline-flex h-9 w-9 items-center justify-center rounded-full
                 bg-white shadow ring-1 ring-slate-200 hover:bg-slate-50 transition"
          aria-label="Desplazar pestañas a la izquierda"
        >
          <span class="text-slate-700 text-xl leading-none">‹</span>
        </button>

        <!-- Botón der (solo si hay overflow) -->
        <button
          v-if="canScrollRight"
          type="button"
          @click="scrollByDir('right')"
          class="absolute right-2 top-1/2 -translate-y-1/2 z-10
                 inline-flex h-9 w-9 items-center justify-center rounded-full
                 bg-white shadow ring-1 ring-slate-200 hover:bg-slate-50 transition"
          aria-label="Desplazar pestañas a la derecha"
        >
          <span class="text-slate-700 text-xl leading-none">›</span>
        </button>

        <!-- Fade visual: indica que hay más -->
        <div
          v-if="canScrollLeft"
          class="pointer-events-none absolute left-0 top-0 h-full w-10 rounded-l-2xl
                 bg-gradient-to-r from-white via-white/80 to-transparent"
        />
        <div
          v-if="canScrollRight"
          class="pointer-events-none absolute right-0 top-0 h-full w-10 rounded-r-2xl
                 bg-gradient-to-l from-white via-white/80 to-transparent"
        />

        <div
          ref="scrollerRef"
          class="flex items-center gap-3 overflow-x-auto scrollbar-hide px-1 py-1
                 scroll-smooth snap-x snap-mandatory"
        >
          <button
            v-for="t in items"
            :key="t.key"
            type="button"
            role="tab"
            :aria-selected="activeKey === t.key"
            :tabindex="activeKey === t.key ? 0 : -1"
            @click="setActive(String(t.key))"
            class="group relative inline-flex shrink-0 items-center gap-2
                   rounded-full px-4 py-2 text-sm sm:text-base font-semibold
                   transition focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-300
                   snap-start"
            :data-active="activeKey === t.key"
            :class="activeKey === t.key
              ? 'bg-white text-slate-900 shadow-sm'
              : 'bg-white text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
          >
            <!-- Borde con degradado verde-azul -->
            <span
              class="pointer-events-none absolute inset-0 rounded-full p-[2px]"
              :class="activeKey === t.key
                ? 'bg-gradient-to-r from-emerald-500 to-sky-500'
                : 'bg-gradient-to-r from-emerald-400/35 to-sky-400/35'"
            >
              <span class="block h-full w-full rounded-full bg-white" />
            </span>

            <!-- Contenido por arriba del borde -->
            <span class="relative inline-flex items-center gap-2">
              <img
                v-if="t.iconSrc"
                :src="t.iconSrc"
                :alt="t.iconAlt || t.label"
                class="h-5 w-5 sm:h-6 sm:w-6"
              />
              <span class="whitespace-nowrap">{{ t.label }}</span>
            </span>

            <!-- “glow” suave al estar activo -->
            <span
              v-if="activeKey === t.key"
              class="pointer-events-none absolute -inset-1 rounded-full blur-md
                     bg-gradient-to-r from-emerald-500/25 to-sky-500/25"
            />
          </button>
        </div>
      </div>
    </div>

    <div class="mt-4">
      <slot :activeKey="activeKey"></slot>
    </div>
  </div>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
