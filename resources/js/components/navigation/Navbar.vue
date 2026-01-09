<script setup lang="ts">
    import { computed } from 'vue'
    import { Link, usePage } from '@inertiajs/vue3'
    
    import Logo from '@/components/ui/Logo.vue'
    import NavLinks from '@/components/navigation/NavLinks.vue'
    import MobileNavSheet from '@/components/navigation/MobileNavSheet.vue'
    
    defineEmits<{ (e: 'openVacancies'): void }>()
    
    const page = usePage()
    
    const activeKey = computed<'servicios' | 'sucursales' | ''>(() => {
      const url = (page.url || '').toLowerCase()
      if (url.startsWith('/sucursales')) return 'sucursales'
      if (url === '/' || url.startsWith('/index')) return 'servicios'
      return ''
    })
    </script>
    
    <template>
      <!-- Overlay encima del hero -->
      <header class="absolute inset-x-0 top-0 z-50 w-full">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 md:px-6 md:py-6 md:justify-end">
    
          <!-- LOGO: SOLO MÓVIL -->
          <div class="md:hidden">
            <Link href="/" aria-label="Ir al inicio" class="inline-flex items-center">
              <Logo />
            </Link>
          </div>
    
          <!-- DESKTOP: TODO A LA DERECHA -->
          <div class="ml-auto hidden items-center gap-3 md:flex">
            <NavLinks class="shrink-0" variant="desktop" :active="activeKey" />
    
            <button
              type="button"
              class="group relative inline-flex items-center justify-center rounded-full bg-black px-6 py-2
                     text-xs font-extrabold tracking-widest text-white shadow-sm transition
                     hover:shadow-md hover:opacity-95 active:scale-[0.98]"
              @click="$emit('openVacancies')"
            >
              <span class="relative z-10">BOLSA DE TRABAJO</span>
              <span
                class="pointer-events-none absolute inset-0 -z-10 rounded-full opacity-0 blur-md
                       transition-opacity duration-300 group-hover:opacity-40"
                style="background: radial-gradient(circle at 30% 30%, rgba(29,193,162,.45), transparent 55%)"
              />
            </button>
          </div>
    
          <!-- MÓVIL: ACCIONES A LA DERECHA (SIN MOVER TU DISEÑO) -->
          <div class="flex items-center gap-2 md:hidden">

            <button
              type="button"
              class="group relative inline-flex items-center justify-center rounded-full bg-black px-4 py-2
                     text-[11px] font-extrabold tracking-widest text-white shadow-sm transition
                     hover:shadow-md hover:opacity-95 active:scale-[0.98]"
              @click="$emit('openVacancies')"
            >
              <span class="relative z-10">BOLSA DE TRABAJO</span>
              <span
                class="pointer-events-none absolute inset-0 -z-10 rounded-full opacity-0 blur-md
                       transition-opacity duration-300 group-hover:opacity-35"
                style="background: radial-gradient(circle at 30% 30%, rgba(29,193,162,.45), transparent 55%)"
              />
            </button>
    
            <MobileNavSheet :active="activeKey" />
          </div>
        </div>
      </header>
    </template>
    