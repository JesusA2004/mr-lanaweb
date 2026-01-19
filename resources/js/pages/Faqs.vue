<!-- resources/js/Pages/Faqs/Index.vue -->
<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import Container from '@/components/ui/Container.vue'
import FaqAccordion from '@/components/faq/FaqAccordion.vue'
import { faqs } from '@/data/faqs'
</script>

<template>
  <Head title="FAQs | Mr Lana" />
  <PublicLayout>
    <section class="relative overflow-hidden bg-black py-10 sm:py-14 md:py-20 lg:py-24">
      <!-- negro elegante (solo capas sutiles, sin blur) -->
      <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-white/5 via-transparent to-white/5"></div>
      <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(80rem_40rem_at_50%_-10%,rgba(56,189,248,0.10),transparent_60%)]"></div>

      <Container>
        <div class="relative">
          <FaqAccordion :items="faqs" />
        </div>
      </Container>
    </section>
  </PublicLayout>
</template>
