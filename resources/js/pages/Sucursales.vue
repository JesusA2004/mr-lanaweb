<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import Container from '@/components/ui/Container.vue'
    import SectionHeader from '@/components/ui/SectionHeader.vue'
    import BranchesGrid from '@/components/branches/BranchesGrid.vue'
    import { branches, zones } from '@/data/sucursales'
    </script>
    
    <template>
      <Head title="Sucursales | Mr Lana" />
      <PublicLayout>
        <section class="py-14">
          <Container>
            <SectionHeader
              badge="Cobertura"
              title="Sucursales"
              subtitle="Encuentra tu sucursal y solicita con seguimiento claro."
              align="left"
            />
            <BranchesGrid :branches="branches" :zones="zones as any" defaultZone="Centro" />
          </Container>
        </section>
      </PublicLayout>
    </template>
    