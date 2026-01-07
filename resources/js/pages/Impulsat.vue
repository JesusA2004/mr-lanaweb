<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import Container from '@/components/ui/Container.vue'
    import LoanLandingHeader from '@/components/forms/LoanLandingHeader.vue'
    import LoanRequestForm from '@/components/forms/LoanRequestForm.vue'
    import { branches } from '@/data/sucursales'
    
    function onSubmit(payload: any) {
      console.log('submit impulsat', payload)
    }
    </script>
    
    <template>
      <Head title="Impulsa.t | Mr Lana" />
      <PublicLayout>
        <LoanLandingHeader
          badge="Impulsa.t"
          title="Financiamiento sin fricción"
          subtitle="Envía tu solicitud y te contactamos."
        />
    
        <Container>
          <div class="grid gap-8 lg:grid-cols-2" id="solicitar">
            <div class="rounded-3xl border border-slate-200 bg-white p-8">
              <LoanRequestForm :branches="branches" :showBusinessToggle="false" @submit="onSubmit" />
            </div>
    
            <div class="rounded-3xl border border-slate-200 bg-white p-8">
              <h3 class="text-xl font-bold text-slate-900">Listo para escalar</h3>
              <p class="mt-2 text-slate-600">
                Esta landing ya queda preparada para que mañana agregues autenticación y módulos sin reescribir todo.
              </p>
            </div>
          </div>
        </Container>
      </PublicLayout>
    </template>
    