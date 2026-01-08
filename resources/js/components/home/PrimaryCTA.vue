<script setup lang="ts">
    import { Link } from '@inertiajs/vue3'
    import type { SlideOverlay } from '@/data/homeSlides'
    
    defineProps<{
        overlay: SlideOverlay
    }>()
    
    const toneClass = (tone: string) => {
        if (tone === 'accent') return 'text-emerald-500'
        if (tone === 'muted') return 'text-white/85'
        return 'text-white'
    }
</script>
    
<template>
    <!-- Contenedor -->
    <div class="w-full rounded-xl bg-black/20 p-4 backdrop-blur-sm
    sm:rounded-2xl sm:p-5 md:w-[440px] md:p-7">
        <!-- Titulo -->
        <div class="text-lg font-extrabold leading-snug
        sm:text-xl md:text-3xl md:leading-tight" >
            <template v-for="(p, i) in overlay.titleParts" :key="i">
                <span :class="[toneClass(p.tone), p.bold ? 'font-extrabold' : 'font-semibold']">
                    {{ p.text }}
                </span>
                <span v-if="p.breakAfter" class="block"></span>
            </template>
        </div>
    
        <!-- Subtitulo -->
        <div class="mt-1.5 text-sm font-semibold sm:text-base md:mt-2 md:text-lg">
            <template v-for="(p, i) in overlay.subtitleParts" :key="i">
                <span :class="[toneClass(p.tone), p.bold ? 'font-bold' : 'font-semibold']">
                    {{ p.text }}
                </span>
            </template>
        </div>
    
        <!-- Boton -->
        <Link :href="overlay.ctaHref" class="mt-4 inline-flex w-full items-center justify-center 
        rounded-full bg-black px-4 py-2.5 text-sm font-extrabold tracking-wide text-white
        shadow-sm transition hover:opacity-90 hover:scale-[1.02] active:scale-[0.98]
        sm:px-5 sm:py-3 sm:text-base md:mt-5 md:w-auto md:px-6 md:py-3 md:text-lg">
            {{ overlay.ctaLabel }}
        </Link>
    </div>
</template>
    