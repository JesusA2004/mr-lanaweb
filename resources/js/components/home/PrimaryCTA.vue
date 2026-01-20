<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import type { SlideOverlay } from '@/data/homeSlides'

const props = defineProps<{
  overlay: SlideOverlay
  compact?: boolean
}>()

const toneClass = (tone: string) => {
  if (tone === 'accent') return 'text-emerald-500'
  if (tone === 'muted') return 'text-white/85'
  if (tone === 'black') return 'text-teal-400'
  return 'text-white'
}
</script>

<template>
  <div
    :class="[
      'w-full text-center items-center',
      'rounded-xl bg-black/40 backdrop-blur-sm',
      props.compact
        ? 'p-2.5 rounded-lg bg-black/35'
        : 'p-4 sm:rounded-2xl sm:p-5 md:w-[300px] md:p-4 lg:w-[500px] 2xl:w-[500px] 2xl:p-6'
    ]"
  >
    <!-- Título -->
    <div
      :class="[
        'font-extrabold',
        props.compact
          ? 'text-[13px] leading-[1.15]'
          : 'text-lg leading-snug sm:text-xl md:text-2xl md:leading-tight 2xl:text-3xl'
      ]"
    >
      <template v-for="(p, i) in overlay.titleParts" :key="i">
        <span :class="[toneClass(p.tone), p.bold ? 'font-extrabold' : 'font-semibold']">
          {{ p.text }}
        </span>
        <span v-if="p.breakAfter" class="block" />
      </template>
    </div>

    <!-- Subtítulo -->
    <div
      :class="[
        props.compact ? 'mt-1 text-[11px] font-semibold leading-[1.2]' : 'mt-1.5 text-sm font-semibold sm:text-base md:mt-2 md:text-base 2xl:text-2xl'
      ]"
    >
      <template v-for="(p, i) in overlay.subtitleParts" :key="i">
        <span :class="[toneClass(p.tone), p.bold ? 'font-bold' : 'font-semibold']">
          {{ p.text }}
        </span>
      </template>
    </div>

    <!-- Botón -->
    <Link
      :href="overlay.ctaHref"
      :class="[
        'inline-flex items-center justify-center w-full rounded-full bg-emerald-500 text-white font-extrabold tracking-wide',
        'transition hover:opacity-90 active:scale-[0.98]',
        props.compact
          ? 'mt-2 px-3 py-2 text-[11px]'
          : 'mt-4 px-4 py-2.5 text-sm shadow-sm hover:scale-[1.02] sm:px-5 sm:py-3 sm:text-base md:mt-2 md:w-auto md:px-4 md:py-4 md:text-base 2xl:text-2xl'
      ]"
    >
      {{ overlay.ctaLabel }}
    </Link>
  </div>
</template>
