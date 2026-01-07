<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import HeroCarousel from '@/components/home/HeroCarousel.vue'
    import PromoBanners from '@/components/home/PromoBanners.vue'
    import AppPromoModal from '@/components/home/AppPromoModal.vue'
    import ProductsPromoModal from '@/components/home/ProductsPromoModal.vue'

    import { homeSlides } from '@/data/homeSlides'
    import { homeBanners } from '@/data/homeBanners'

    function onCtaClick(slideId: string) {
      // ejemplo: puedes scrollear a solicitar o abrir modal etc.
      const el = document.querySelector('#solicitar')
      if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
</script>

    <template>
      <Head title="Mr Lana" />

      <PublicLayout>
        <!-- Modales como en tu sitio -->
        <AppPromoModal />
        <ProductsPromoModal />

        <!-- HERO: FULL WIDTH (sin Container) -->
        <HeroCarousel :slides="homeSlides" :autoplayMs="9000" :pauseAfterInteractMs="8000" />

        <!-- BANNERS/SECCIONES FULL WIDTH (los 3 artes del home + app banner, etc) -->
        <PromoBanners :banners="homeBanners" />

        <section id="solicitar" class="w-full bg-white">
          <div class="mx-auto w-full max-w-6xl px-4 py-14">
            <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">
              Solicita tu crédito
            </h2>
            <p class="mt-2 text-slate-600">
              Aquí puedes conectar tu formulario real. Esta sección sí va “contenida”
              porque ya no es banner, es contenido.
            </p>

            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
              <div class="text-sm text-slate-600">
                Placeholder de formulario. Conecta tu LoanRequestForm cuando quieras.
              </div>
            </div>
          </div>
        </section>
      </PublicLayout>
    </template>
