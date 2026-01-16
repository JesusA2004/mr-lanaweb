<script setup lang="ts">
    import { Link } from '@inertiajs/vue3'
    import type { SlideOverlay } from '@/data/homeSlides'

    defineProps<{
        overlay: SlideOverlay
    }>()

    // Colores para span de texto en CTA
    const toneClass = (tone: string) => {
        if (tone === 'accent') return 'text-emerald-500'
        if (tone === 'muted') return 'text-white/85'
        if (tone === 'black') return 'text-teal-400'
        return 'text-white'
    }
</script>

<template>
    <!-- Contenedor -->
    <div class="w-full rounded-xl bg-black/40 p-4 backdrop-blur-sm
    sm:rounded-2xl sm:p-5 md:w-[300px] md:p-4 lg:w-[500px] 2xl:w-[500px] 2xl:p-6 items-center
    text-center">
        <!-- Titulo -->
        <div class="text-lg font-extrabold leading-snug
        sm:text-xl md:text-2xl md:leading-tight 2xl:text-3xl" >
            <template v-for="(p, i) in overlay.titleParts" :key="i">
                <span :class="[toneClass(p.tone), p.bold ? 'font-extrabold' : 'font-semibold']">
                    {{ p.text }}
                </span>
                <span v-if="p.breakAfter" class="block"></span>
            </template>
        </div>

        <!-- Subtitulo -->
        <div class="mt-1.5 text-sm font-semibold sm:text-base md:mt-2 md:text-base 2xl:text-2xl">
            <template v-for="(p, i) in overlay.subtitleParts" :key="i">
                <span :class="[toneClass(p.tone), p.bold ? 'font-bold' : 'font-semibold']">
                    {{ p.text }}
                </span>
            </template>
        </div>

        <!-- Boton -->
        <Link :href="overlay.ctaHref" class="mt-4 inline-flex w-full items-center
        justify-center rounded-full bg-emerald-500 px-4 py-2.5 text-sm font-extrabold
        tracking-wide text-white shadow-sm transition hover:opacity-90
        hover:scale-[1.02] active:scale-[0.98] sm:px-5 sm:py-3 sm:text-base md:mt-2
        md:w-auto md:px-4 md:py-4 md:text-base 2xl:text-2xl">
            {{ overlay.ctaLabel }}
        </Link>
    </div>
</template>
