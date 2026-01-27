<script setup lang="ts">
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import HeroCarousel from '@/components/home/HeroCarousel.vue'
    import PromoBanners from '@/components/home/PromoBanners.vue'
    import AppDownloadBanner from '@/components/home/AppDownloadBanner.vue'
    import AppPromoModal from '@/components/home/AppPromoModal.vue'
    import ProductsPromoModal from '@/components/home/ProductsPromoModal.vue'

    import { homeSlides } from '@/data/homeSlides'
    import { homeBanners } from '@/data/homeBanners'

    /**
     * Scroll suave a anclas desde PromoBanners
     */
    function onBannerCta(href?: string) {
        if (!href) return
        if (!href.startsWith('#')) return

        const el = globalThis.document?.querySelector(href)
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
</script>

<template>
    <PublicLayout>
        <AppPromoModal />
        <ProductsPromoModal />

        <!-- HERO -->
        <HeroCarousel :slides="homeSlides" :autoplayMs="9000" :pauseAfterInteractMs="8000" />

        <!-- ESPACIO BLANCO DESPUÉS DEL SLIDER -->
        <div class="w-full bg-white h-10 sm:h-12 md:h-14 lg:h-16" />

        <!-- PROMO BANNERS -->
        <PromoBanners :banners="homeBanners" @cta="onBannerCta" />

        <div class="py-8 sm:py-10 md:py-12">
            <AppDownloadBanner
                appStoreUrl="#"
                playStoreUrl="https://play.google.com/store/apps/details?id=io.mr.lana&pcampaignid=web_share"
            />
        </div>

    </PublicLayout>
</template>
