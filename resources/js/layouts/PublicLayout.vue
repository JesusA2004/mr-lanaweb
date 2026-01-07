<script setup lang="ts">
    import Navbar from '@/components/navigation/Navbar.vue'
    import Footer from '@/components/navigation/Footer.vue'
    import FloatingCTA from '@/components/layout/FloatingCTA.vue'
    import GradientBackground from '@/components/ui/GradientBackground.vue'
    
    defineProps<{ title?: string }>()
    </script>
    
    <template>
      <GradientBackground>
        <TopBarContact phone="777 000 0000" email="contacto@mr-lana.com" hours="Lun a Sáb" />
        <Navbar ctaHref="#solicitar" ctaLabel="Solicitar" />
    
        <main class="min-h-[60vh]">
          <slot />
        </main>
    
        <Footer />
        <FloatingCTA href="#solicitar" label="Solicitar ahora" />
      </GradientBackground>
    </template>
    