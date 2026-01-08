<script setup lang="ts">
    import { computed } from 'vue'
    import { Link } from '@inertiajs/vue3'
    
    import {
      Sheet,
      SheetContent,
      SheetHeader,
      SheetTitle,
      SheetTrigger,
      SheetClose,
    } from '@/components/ui/sheet'
    
    import Logo from '@/components/ui/Logo.vue'
    
    const menu = computed(() => ([
      { label: 'Servicios', href: '/', icon: '⌂' }, // Home = Servicios
      { label: 'Impulsa tu negocio', href: '/impulsa-tu-negocio', icon: '▦' },
      { label: 'Impulsa.t', href: '/impulsat', icon: '⎋' },
      { label: 'Sucursales', href: '/sucursales', icon: '▣' },
      { label: 'FAQs', href: '/faqs', icon: '?' },
    ]))
    </script>
    
    <template>
      <Sheet>
        <SheetTrigger as-child>
          <!-- Toggle -->
          <button
            type="button"
            aria-label="Abrir menú"
            class="group relative inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/75 shadow-sm backdrop-blur transition hover:bg-white/90"
          >
            <span class="absolute h-0.5 w-5 rounded bg-black/90 -translate-y-2"></span>
            <span class="absolute h-0.5 w-5 rounded bg-black/90"></span>
            <span class="absolute h-0.5 w-5 rounded bg-black/90 translate-y-2"></span>
          </button>
        </SheetTrigger>
    
        <!-- OJO: ocultamos el close default de shadcn con data-[state] overlay -->
        <SheetContent side="left" class="p-0 [&>button]:hidden">
          <div class="h-full bg-zinc-950">
            <div class="p-5">
              <SheetHeader class="space-y-4">
                <div class="flex items-center justify-between">
                  <Logo />
    
                  <!-- ÚNICO botón cerrar (el grande que sí quieres) -->
                  <SheetClose as-child>
                    <button
                      class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white shadow-sm transition hover:bg-white/15"
                      aria-label="Cerrar"
                    >
                      ✕
                    </button>
                  </SheetClose>
                </div>
    
                <SheetTitle class="text-white text-lg font-extrabold">
                  Bienvenido
                </SheetTitle>
              </SheetHeader>
    
              <div class="mt-6 space-y-2">
                <SheetClose v-for="it in menu" :key="it.href" as-child>
                  <Link
                    :href="it.href"
                    class="flex items-center gap-3 rounded-2xl px-3 py-3 text-white/90 transition hover:bg-white/10"
                  >
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-white/10 text-white">
                      {{ it.icon }}
                    </span>
                    <span class="text-sm font-semibold">{{ it.label }}</span>
                  </Link>
                </SheetClose>
              </div>
            </div>
          </div>
        </SheetContent>
      </Sheet>
    </template>
    