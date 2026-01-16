<!-- resources/js/components/home/PromoBanners.vue -->
<script setup lang="ts">
    import { onBeforeUnmount, onMounted, ref } from 'vue'
    import { Link } from '@inertiajs/vue3'
    import type { HomeBanner } from '@/data/homeBanners'

    /**
     * Props:
     * - banners: lista de banners (3)
     */
    const props = defineProps<{
        banners: HomeBanner[]
    }>()

    /**
     * Emit:
     * - cta(href): Index.vue hace scroll suave si es #anchor
     */
    const emit = defineEmits<{
        (e: 'cta', href?: string): void
    }>()

    function onCtaClick(href?: string) {
        if (!href) return
        if (href.startsWith('#')) emit('cta', href)
    }

    // Scroll reveal (sin librerías)
    const inView = ref<Record<string, boolean>>({})
    let io: IntersectionObserver | null = null

    onMounted(() => {
        io = new IntersectionObserver(
            (entries) => {
                for (const e of entries) {
                    const id = (e.target as HTMLElement).dataset.bannerId
                    if (!id) continue
                    if (e.isIntersecting) {
                    inView.value[id] = true
                    io?.unobserve(e.target)
                    }
                }
            },
            { threshold: 0.14, rootMargin: '120px 0px -90px 0px' }
        )

        requestAnimationFrame(() => {
            globalThis.document?.querySelectorAll('[data-banner-id]').forEach((el) => io?.observe(el))
        })
    })

    onBeforeUnmount(() => {
        io?.disconnect()
        io = null
    })

    const revealClass = (id: string) => {
        const ok = !!inView.value[id]
        return [
            'will-change-transform',
            'transition-[transform,opacity] duration-450 ease-[cubic-bezier(.22,1,.36,1)]',
            ok ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4',
        ].join(' ')
    }

    // ALTURA FIJA GLOBAL (los 3 iguales)
    const bannerHeightClass =
        'h-[220px] sm:h-[320px] md:h-[340px] lg:h-[460px] xl:h-[560px] 2xl:h-[750px]'

    // Texto 
    const kickerClass =
        [
            'text-black font-extrabold tracking-tight',
            'leading-[1.12] md:leading-[1.10] xl:leading-[1.06]',
            'drop-shadow-[0_14px_28px_rgba(0,0,0,0.60)]',
            'text-[18px] sm:text-[20px] md:text-[26px] lg:text-[34px] xl:text-[44px] 2xl:text-[56px]',
            'max-w-[16rem] sm:max-w-[30rem] md:max-w-[40rem] lg:max-w-[46rem] xl:max-w-[54rem] 2xl:max-w-[62rem]',
        ].join(' ')

    // Botón
    const ctaClass =
        [
            'cta-glow relative inline-flex items-center justify-center rounded-full',
            'bg-black text-white',
            'px-5 py-2.5 text-[18px]',
            'sm:px-7 sm:py-3 sm:text-[22px]',
            'md:px-9 md:py-4 md:text-[25px]',
            'lg:px-11 lg:py-5 lg:text-[30px]',
            'xl:px-14 xl:py-6 xl:text-[35px]',
            '2xl:px-16 2xl:py-7 2xl:text-[40px]',
            'font-extrabold tracking-wide',
            'transition-[box-shadow,transform,opacity] duration-200 ease-[cubic-bezier(.22,1,.36,1)]',
            'hover:-translate-y-[1px]',
            'hover:opacity-95',
            'active:translate-y-0 active:scale-[0.99]',
        ].join(' ')
</script>

<template>
    <section class="w-full bg-white">
        <div class="w-full">
            <div v-for="b in props.banners" :key="b.id" class="w-full" :class="b.className">
                <!-- Reveal wrapper -->
                <div :data-banner-id="b.id" class="w-full" :class="revealClass(b.id)">
                    <!-- Banner frame (sin bordes redondos) -->
                    <div class="banner-frame group relative w-full bg-white overflow-hidden">
                        <!-- Altura fija -->
                        <div :class="['relative w-full', bannerHeightClass]">
                            <div class="media-layer absolute inset-0">
                                <!-- Imagen base -->
                                <picture class="block h-full w-full">
                                    <source :srcset="b.mobileSrc" media="(max-width: 768px)" />
                                    <img :src="b.desktopSrc" :alt="b.alt"
                                    :class="['banner-img block h-full w-full select-none',
                                        b.overlaySrc ? 'object-contain object-right' : 'object-cover object-center']"
                                    loading="lazy"  draggable="false" />
                                </picture>

                            </div>

                            <!-- Texto + CTA -->
                            <div v-if="b.ctaLabel && b.ctaHref"
                            :class="['absolute inset-0 z-20 flex',b.overlaySrc ? 'items-end' : 'items-center']">
                            <div :class="['w-full px-5 sm:px-10 md:px-12 lg:px-14 xl:px-16 2xl:px-20',
                            b.overlaySrc ? 'pb-6 sm:pb-8 md:pb-10 lg:pb-12 xl:pb-10 2xl:pb-12'
                            : 'py-6 sm:py-8 md:py-10 lg:py-12 xl:py-14 2xl:py-16 translate-y-6 sm:translate-y-10 md:translate-y-12 lg:translate-y-14']">
                                    <div class="mx-auto w-full max-w-7xl">
                                        <!-- Texto separado (no se “encima” del logo) -->
                                        <div v-if="b.kickerParts?.length" class="mb-4 sm:mb-5 md:mb-6 lg:mb-7">
                                            <p :class="kickerClass">
                                                <template v-for="(p, idx) in b.kickerParts" :key="idx">
                                                    <span v-if="p.highlight" class="text-white">
                                                        {{ p.text }}
                                                    </span>
                                                    <span v-else>{{ p.text }}</span>
                                                </template>
                                            </p>
                                        </div>

                                        <!-- CTA -->
                                        <div class="flex items-center">
                                            <button v-if="b.ctaHref.startsWith('#')" type="button"
                                            @click="onCtaClick(b.ctaHref)" :class="ctaClass">
                                                <span class="relative z-10">{{ b.ctaLabel }}</span>
                                                <span class="glow pointer-events-none absolute inset-0
                                                -z-10 rounded-full opacity-0 blur-lg"
                                                style="background: radial-gradient(circle at 30% 30%, rgba(29,193,162,.60), transparent 62%)"/>
                                            </button>

                                            <Link v-else :href="b.ctaHref" :class="ctaClass">
                                                <span class="relative z-10">{{ b.ctaLabel }}</span>
                                                <span class="glow pointer-events-none absolute inset-0
                                                -z-10 rounded-full opacity-0 blur-lg"
                                                style="background: radial-gradient(circle at 30% 30%, rgba(29,193,162,.60), transparent 62%)"/>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shine overlay (hover) -->
                            <span class="banner-shine pointer-events-none absolute inset-0 z-[5]" />
                        </div>
                    </div>

                    <!-- Espacio blanco entre banners -->
                    <div class="w-full bg-white h-8 sm:h-4 md:h-8 lg:h-10 xl:h-16 2xl:16" />
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
    /* Hover moderno de banner: micro-lift + shine + contraste */
    @media (hover: hover) {
        .banner-frame {
            transition: transform 220ms cubic-bezier(.22,1,.36,1), filter 220ms cubic-bezier(.22,1,.36,1);
        }

        .banner-frame:hover {
            transform: translateY(-2px);
            filter: saturate(1.04) contrast(1.03);
        }

        .media-layer {
            transition: transform 700ms cubic-bezier(.22,1,.36,1);
            transform-origin: center;
        }
        
        .banner-frame:hover .media-layer {
            transform: scale(1.015);
        }

        /* Shine */
        .banner-shine {
            opacity: 0;
            transition: opacity 220ms cubic-bezier(.22,1,.36,1);
            background: linear-gradient(
            115deg,
            rgba(255,255,255,0) 0%,
            rgba(255,255,255,0.08) 35%,
            rgba(255,255,255,0.18) 50%,
            rgba(255,255,255,0.08) 65%,
            rgba(255,255,255,0) 100%
            );
            mix-blend-mode: soft-light;
        }

        .banner-frame:hover .banner-shine {
            opacity: 1;
        }

        /* Glow del botón solo cuando hay hover real */
        .cta-glow:hover .glow {
            opacity: 0.45;
            transition: opacity 200ms cubic-bezier(.22,1,.36,1);
        }
    }
</style>
