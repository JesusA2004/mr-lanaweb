<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import Container from '@/components/ui/Container.vue'
    import SectionHeader from '@/components/ui/SectionHeader.vue'
    import FaqAccordion from '@/components/faq/FaqAccordion.vue'
    import { faqs } from '@/data/faqs'
    </script>
    
    <template>
      <Head title="FAQs | Mr Lana" />
      <PublicLayout>
        <section class="py-14">
          <Container>
            <SectionHeader
              badge="Ayuda"
              title="Preguntas frecuentes"
              subtitle="Respuestas claras para avanzar sin fricción."
            />
            <FaqAccordion :items="faqs" />
          </Container>
        </section>
      </PublicLayout>
    </template>
    