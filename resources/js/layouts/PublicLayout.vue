<script setup lang="ts">
    import Navbar from '@/components/navigation/Navbar.vue'
    import Footer from '@/components/navigation/Footer.vue'
    import FloatingCTA from '@/components/layout/FloatingCTA.vue'

    defineProps<{ title?: string }>()
    </script>

    <template>
      <div class="min-h-screen bg-white text-slate-900">

        <!-- NAVBAR SOLO EN MÓVIL -->
        <div class="block md:hidden">
          <Navbar mobileBgSrc="/img/home/banner-gradient.png" />
        </div>

        <main class="w-full">
          <slot />
        </main>

        <Footer />
        <FloatingCTA href="#solicitar" label="Solicitar Ahora" />
      </div>
    </template>
