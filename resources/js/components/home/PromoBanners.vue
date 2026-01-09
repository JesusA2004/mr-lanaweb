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

    /* -------------------------------------------------------
     * Scroll reveal (sin librerías)
     * ------------------------------------------------------*/
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

    /**
     * ALTURA FIJA GLOBAL (los 3 iguales)
     */
    const bannerHeightClass =
      'h-[240px] sm:h-[320px] md:h-[400px] lg:h-[460px] xl:h-[520px] 2xl:h-[600px]'

    // Texto blanco (más grande y bien proporcionado)
    const kickerClass =
        [
            'text-white font-extrabold tracking-tight',
            'leading-[1.12] md:leading-[1.10] xl:leading-[1.06]',
            'drop-shadow-[0_14px_28px_rgba(0,0,0,0.60)]',
            'text-[16px] sm:text-[20px] md:text-[24px] lg:text-[28px] xl:text-[32px] 2xl:text-[38px]',
            'max-w-[18rem] sm:max-w-[28rem] md:max-w-[36rem] lg:max-w-[42rem] xl:max-w-[48rem] 2xl:max-w-[56rem]',
        ].join(' ')

    // Botón
    const ctaClass =
        [
            'cta-glow relative inline-flex items-center justify-center rounded-full',
            'bg-black text-white',
            'px-6 py-3 text-[13px]',
            'sm:px-7 sm:py-3.5 sm:text-[15px]',
            'md:px-8 md:py-4 md:text-[16px]',
            'lg:px-10 lg:py-[18px] lg:text-[18px]',
            'xl:px-11 xl:py-5 xl:text-[19px]',
            '2xl:px-12 2xl:py-[22px] 2xl:text-[20px]',
            'font-extrabold tracking-wide',
            'shadow-[0_18px_44px_rgba(0,0,0,0.32)]',
            'transition-[box-shadow,transform,opacity] duration-200 ease-[cubic-bezier(.22,1,.36,1)]',
            'hover:shadow-[0_26px_66px_rgba(0,0,0,0.40)]',
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
                    <div class="banner-frame group relative w-full bg-white">
                        <!-- Altura fija -->
                        <div :class="['relative w-full', bannerHeightClass]">
                            <!-- Imagen base -->
                            <picture class="block h-full w-full">
                                <source :srcset="b.mobileSrc" media="(max-width: 768px)" />
                                <img :src="b.desktopSrc" :alt="b.alt"
                                class="banner-img block h-full w-full object-cover select-none"
                                loading="lazy"  draggable="false" />
                            </picture>

                            <!-- Overlay (solo banner-1) -->
                            <img v-if="b.overlaySrc" :src="b.overlaySrc"
                            class="pointer-events-none absolute inset-0 z-10 h-full w-full
                            object-cover select-none" draggable="false"/>

                            <!-- Texto + CTA -->
                            <div v-if="b.ctaLabel && b.ctaHref" class="absolute inset-0 z-20
                            flex items-end">
                                <div class="w-full px-5 pb-6 sm:px-10 sm:pb-8 md:px-12 md:pb-10
                                lg:px-14 lg:pb-12 xl:px-16 xl:pb-14 2xl:px-20 2xl:pb-16">
                                    <div class="mx-auto w-full max-w-7xl">
                                        <!-- Texto blanco separado (no se “encima” del logo) -->
                                        <div v-if="b.kickerParts?.length" class="mb-4 sm:mb-5 md:mb-6 lg:mb-7">
                                            <p :class="kickerClass">
                                                <template v-for="(p, idx) in b.kickerParts" :key="idx">
                                                    <span v-if="p.highlight" class="text-emerald-300">
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
                    <div class="w-full bg-white h-10 sm:h-12 md:h-14 lg:h-16" />
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

        .banner-img {
            transition: transform 700ms cubic-bezier(.22,1,.36,1);
        }

        .banner-frame:hover .banner-img {
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
