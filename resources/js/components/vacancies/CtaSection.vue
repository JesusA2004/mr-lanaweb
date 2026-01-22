<script setup lang="ts">
    type BannerSources = Partial<{
        base: string   // <sm
        sm: string     // >=sm
        md: string     // >=md
        lg: string     // >=lg
        xl: string     // >=xl
        '2xl': string  // >=2xl
    }>

    const props = withDefaults(
        defineProps<{
            sources: BannerSources
            alt?: string
            buttonText?: string
            buttonClass?: string
            overlayClass?: string
        }>(),
        {
            alt: 'Banner',
            buttonText: 'Bolsa de trabajo',
        }
    )
    const emit = defineEmits<{ (e: 'click'): void }>()
</script>

<template>
    <section class="relative w-full">
        <!-- base (<sm) -->
        <img v-if="sources.base" :src="sources.base" :alt="alt"
        class="block w-full h-auto select-none sm:hidden"
        draggable="false"/>

        <!-- sm (>=sm, <md) -->
        <img v-if="sources.sm" :src="sources.sm" :alt="alt"
        class="hidden w-full h-auto select-none sm:block md:hidden"
        draggable="false"/>

        <!-- md (>=md, <lg) -->
        <img v-if="sources.md" :src="sources.md" :alt="alt"
        class="hidden w-full h-auto select-none md:block lg:hidden"
        draggable="false"/>

        <!-- lg (>=lg, <xl) -->
        <img v-if="sources.lg" :src="sources.lg" :alt="alt"
        class="hidden w-full h-auto select-none lg:block xl:hidden"
        draggable="false"/>

        <!-- xl (>=xl, <2xl) -->
        <img v-if="sources.xl" :src="sources.xl" :alt="alt"
        class="hidden w-full h-auto select-none xl:block 2xl:hidden"
        draggable="false"/>

        <!-- 2xl (>=2xl) -->
        <img v-if="sources['2xl']" :src="sources['2xl']" :alt="alt"
        class="hidden w-full h-auto select-none 2xl:block"
        draggable="false" />

        <!-- Botón overlay -->
        <div class="absolute left-4 top-[65%] sm:left-6 sm:top-[70%]
        md:left-10 md:top-[70%] lg:top-[60%]
        lg:left-12 xl:left-40 2xl:left-60"
        :class="overlayClass">
        <button type="button" @click="emit('click')"
        class="group relative inline-flex items-center justify-center
        rounded-full px-7 py-3 font-extrabold tracking-wide
        text-white bg-gradient-to-r from-[#0EA5E9] via-[#06B6D4]
        to-[#22D3EE] shadow-[0_18px_60px_-25px_rgba(6,182,212,0.65)]
        ring-1 ring-white/20 backdrop-blur-sm transition-all duration-300
        hover:-translate-y-0.5 hover:scale-[1.02]
        hover:shadow-[0_28px_90px_-35px_rgba(6,182,212,0.9)]
        hover:ring-white/40 active:scale-[0.98]
        focus:outline-none focus-visible:ring-4
        focus-visible:ring-cyan-300/50
        text-sm sm:text-base md:text-[15px]
        min-w-[180px] sm:min-w-[240px] md:min-w-[230px]"
        :class="buttonClass">
        <!-- Glow interno suave -->
        <span class="pointer-events-none absolute inset-0 rounded-full
        bg-gradient-to-r from-white/10 via-white/5 to-white/10
        opacity-60"/>

            <!-- Halo glow exterior -->
            <span class="pointer-events-none absolute -inset-1
            rounded-full blur-xl bg-gradient-to-r from-emerald-400/40
            via-teal-400/35 to-cyan-400/40 opacity-0 transition-opacity
            duration-300 group-hover:opacity-100"/>
            <!-- Contenido -->
            <span class="relative flex items-center gap-2">
                <span class="truncate">
                    {{ buttonText }}
                </span>
                <svg class="h-4 w-4 transition-transform duration-300
                group-hover:translate-x-1" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 7l5 5-5 5M6 12h12"/>
                </svg>
            </span>
            </button>
        </div>
    </section>
</template>
