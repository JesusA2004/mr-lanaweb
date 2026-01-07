<script setup lang="ts">
    import { computed, onBeforeUnmount, onMounted, ref } from 'vue'
    import NavLinks from './NavLinks.vue'

    const props = defineProps<{
      mobileBgSrc?: string
    }>()

    const scrolled = ref(false)
    function onScroll() {
      scrolled.value = window.scrollY > 8
    }

    onMounted(() => {
      onScroll()
      window.addEventListener('scroll', onScroll, { passive: true })
    })
    onBeforeUnmount(() => window.removeEventListener('scroll', onScroll))

    /**
     * Reglas:
     * - MÓVIL: fixed + background propio (porque el slider en móvil no “pinta” atrás del nav)
     * - md+: overlay (absolute) y transparente arriba del slider; al scrollear se hace fijo.
     */
    const headerClass = computed(() => {
      // móvil siempre fijo
      return scrolled.value
        ? 'fixed'
        : 'fixed md:absolute'
    })
    </script>

    <template>
      <header class="fixed left-0 top-0 z-[60] w-full ..."
        :class="headerClass"
        :style="{
          // ✅ background SOLO en móvil
          backgroundImage: props.mobileBgSrc ? `url('${props.mobileBgSrc}')` : 'none',
          backgroundSize: 'cover',
          backgroundPosition: 'center',
        }"
      >
        <!-- En md+ NO queremos ese bg: lo apagamos -->
        <div
          class="h-16 w-full"
          :class="[
            // móvil: bg visible
            'bg-white/0',
            // md+: transparente al inicio, sólido al bajar
            scrolled ? 'md:bg-white/90 md:backdrop-blur md:border-slate-200 md:shadow-sm' : 'md:bg-transparent md:border-transparent'
          ]"
        >
          <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-4 sm:px-6">
            <!-- Logo en navbar SOLO móvil (md+ lo pone el slider) -->
            <a href="/" class="block md:hidden">
              <img
                src="/img/logo-mr-lana.png"
                alt="Mr Lana"
                class="h-10 w-auto drop-shadow-[0_8px_16px_rgba(0,0,0,0.25)]"
                loading="eager"
              />
            </a>

            <!-- Links más pegados al botón en desktop -->
            <div class="hidden md:flex flex-1 justify-end">
              <div class="flex items-center gap-6">
                <NavLinks />
                <a
                  href="/bolsa-de-trabajo"
                  class="rounded-full bg-black px-5 py-2 text-sm font-extrabold text-white shadow
                         transition hover:bg-black/90 hover:scale-[1.02] active:scale-[0.98]"
                >
                  Bolsa de trabajo
                </a>
              </div>
            </div>

            <!-- Móvil: botón + hamburguesa (tu menú ya lo tienes) -->
            <div class="flex items-center gap-3 md:hidden">
              <a
                href="/bolsa-de-trabajo"
                class="rounded-full bg-black px-4 py-2 text-xs font-extrabold text-white shadow
                       transition hover:bg-black/90 active:scale-[0.98]"
              >
                Bolsa de trabajo
              </a>

              <!-- aquí va tu botón hamburguesa -->
              <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-black/90 text-white
                       shadow transition hover:bg-black"
                aria-label="Abrir menú"
              >
                ☰
              </button>
            </div>
          </div>
        </div>
      </header>
    </template>
