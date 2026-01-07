<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import HeroCarousel from '@/components/home/HeroCarousel.vue'
    import PromoBanners from '@/components/home/PromoBanners.vue'
    import TrustStrip from '@/components/home/TrustStrip.vue'
    import AppPromoModal from '@/components/home/AppPromoModal.vue'
    import ProductsPromoModal from '@/components/home/ProductsPromoModal.vue'
    import Container from '@/components/ui/Container.vue'
    import SectionHeader from '@/components/ui/SectionHeader.vue'
    import { slides } from '@/data/slides'
    import { branches } from '@/data/sucursales'
    import LoanRequestForm from '@/components/forms/LoanRequestForm.vue'
    
    function onSubmit(payload: any) {
      console.log('submit home', payload)
    }
    </script>
    
    <template>
      <Head title="Mr Lana" />
      <PublicLayout>
        <AppPromoModal />
        <ProductsPromoModal />
    
        <HeroCarousel :slides="slides" />
        <TrustStrip />
        <PromoBanners />
    
        <section class="py-14" id="solicitar">
          <Container>
            <SectionHeader
              badge="Solicitud"
              title="Solicita en minutos"
              subtitle="Proceso claro, seguimiento rápido y sucursal cercana."
              align="left"
            />
    
            <div class="grid gap-8 lg:grid-cols-2">
              <div class="rounded-3xl border border-slate-200 bg-white p-8">
                <LoanRequestForm :branches="branches" :showBusinessToggle="false" @submit="onSubmit" />
              </div>
    
              <div class="rounded-3xl border border-slate-200 bg-white p-8">
                <h3 class="text-xl font-bold text-slate-900">Estrategia simple</h3>
                <p class="mt-2 text-slate-600">
                  Captura tu solicitud. Nosotros nos encargamos del seguimiento y te guiamos en el siguiente paso.
                </p>
                <div class="mt-6 grid gap-3 text-sm text-slate-700">
                  <div class="rounded-2xl bg-[#C2F6EC]/40 p-4">Atención rápida</div>
                  <div class="rounded-2xl bg-[#C2F6EC]/40 p-4">Transparencia en requisitos</div>
                  <div class="rounded-2xl bg-[#C2F6EC]/40 p-4">Sucursal cercana</div>
                </div>
              </div>
            </div>
          </Container>
        </section>
      </PublicLayout>
    </template>
    