<script setup lang="ts">
    import Navbar from '@/components/navigation/Navbar.vue'
    import Footer from '@/components/navigation/Footer.vue'
    import FloatingCTA from '@/components/layout/FloatingCTA.vue'

    defineProps<{ title?: string }>()
    </script>

    <template>
      <div class="min-h-screen bg-white text-slate-900">
        <!-- NAVBAR: SIEMPRE (desktop + mobile) -->
        <Navbar />

        <main class="w-full">
          <slot />
        </main>

        <Footer />
      </div>
    </template>
