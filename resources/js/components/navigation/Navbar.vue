<script setup lang="ts">
    import Logo from '@/components/ui/Logo.vue'
    import NavLinks from './NavLinks.vue'
    </script>
    
    <template>
      <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b">
        <div class="flex h-16 items-center justify-between px-6">
          <Logo />
    
          <div class="hidden md:block">
            <NavLinks />
          </div>
    
          <a
            href="#solicitar"
            class="rounded-lg bg-[#1DC1A2] px-5 py-2 text-sm font-semibold text-white hover:bg-[#106A59]"
          >
            Solicitar
          </a>
        </div>
      </header>
    </template>
    