<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import LegalPage from '@/components/legal/LegalPage.vue'
    </script>
    
    <template>
      <Head title="Términos y condiciones | Mr Lana" />
      <PublicLayout>
        <LegalPage
          title="Términos y condiciones"
          updatedAt="2026-01-01"
          :toc="[
            { id: 'alcance', label: 'Alcance' },
            { id: 'uso', label: 'Uso del sitio' },
            { id: 'limitacion', label: 'Limitación' },
          ]"
        >
          <h2 id="alcance">Alcance</h2>
          <p>Contenido legal aquí. Sustituye por el texto real.</p>
    
          <h2 id="uso">Uso del sitio</h2>
          <p>Contenido legal aquí.</p>
    
          <h2 id="limitacion">Limitación</h2>
          <p>Contenido legal aquí.</p>
        </LegalPage>
      </PublicLayout>
    </template>
    