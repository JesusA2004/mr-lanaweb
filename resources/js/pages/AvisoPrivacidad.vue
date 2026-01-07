<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import LegalPage from '@/components/legal/LegalPage.vue'
    </script>
    
    <template>
      <Head title="Aviso de privacidad | Mr Lana" />
      <PublicLayout>
        <LegalPage
          title="Aviso de privacidad"
          updatedAt="2026-01-01"
          :toc="[
            { id: 'intro', label: 'Introducción' },
            { id: 'datos', label: 'Datos que recabamos' },
            { id: 'finalidades', label: 'Finalidades' },
            { id: 'derechos', label: 'Derechos ARCO' },
          ]"
        >
          <h2 id="intro">Introducción</h2>
          <p>Contenido legal aquí. Sustituye por el texto real.</p>
    
          <h2 id="datos">Datos que recabamos</h2>
          <p>Contenido legal aquí.</p>
    
          <h2 id="finalidades">Finalidades</h2>
          <p>Contenido legal aquí.</p>
    
          <h2 id="derechos">Derechos ARCO</h2>
          <p>Contenido legal aquí.</p>
        </LegalPage>
      </PublicLayout>
    </template>
    