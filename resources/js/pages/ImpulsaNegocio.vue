<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import Container from '@/components/ui/Container.vue'
    import LoanLandingHeader from '@/components/forms/LoanLandingHeader.vue'
    import CreditOptionsTabs from '@/components/forms/CreditOptionsTabs.vue'
    import LoanRequestForm from '@/components/forms/LoanRequestForm.vue'
    import { branches } from '@/data/sucursales'
    import { ref } from 'vue'
    
    const freq = ref<'diario' | 'semanal'>('diario')
    
    function onSubmit(payload: any) {
      console.log('submit impulsa negocio', payload)
    }
    </script>
    
    <template>
      <Head title="Impulsa tu negocio | Mr Lana" />
      <PublicLayout>
        <LoanLandingHeader
          badge="Impulsa tu negocio"
          title="Crédito para operar y crecer"
          subtitle="Selecciona tu frecuencia y envía tu solicitud."
        />
    
        <Container>
          <div class="flex items-center justify-between flex-wrap gap-4">
            <CreditOptionsTabs v-model="freq" />
            <a href="/sucursales" class="text-sm font-semibold text-[#1DC1A2] hover:text-[#106A59]">Ver sucursales</a>
          </div>
    
          <div class="mt-10 grid gap-8 lg:grid-cols-2" id="solicitar">
            <div class="rounded-3xl border border-slate-200 bg-white p-8">
              <LoanRequestForm
                :branches="branches"
                :showBusinessToggle="true"
                :frequency="freq"
                submitLabel="Enviar solicitud"
                @submit="onSubmit"
              />
            </div>
    
            <div class="rounded-3xl border border-slate-200 bg-white p-8">
              <h3 class="text-xl font-bold text-slate-900">Enfoque operativo</h3>
              <p class="mt-2 text-slate-600">
                Diseñado para flujo diario y control semanal. Tú eliges, nosotros ejecutamos con claridad.
              </p>
              <div class="mt-6 grid gap-3 text-sm text-slate-700">
                <div class="rounded-2xl bg-[#C2F6EC]/40 p-4">Estructura simple</div>
                <div class="rounded-2xl bg-[#C2F6EC]/40 p-4">Seguimiento rápido</div>
                <div class="rounded-2xl bg-[#C2F6EC]/40 p-4">Sin fricción</div>
              </div>
            </div>
          </div>
        </Container>
      </PublicLayout>
    </template>
    