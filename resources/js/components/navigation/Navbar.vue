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
  <header class="z-50 w-full sticky top-0 md:absolute md:inset-x-0 md:top-0">
    <!-- MOBILE BAR -->
    <div class="md:hidden w-full bg-gradient-to-r from-[#55D86A] via-[#49D7B8] to-[#4DD7FF] shadow-[0_10px_25px_rgba(0,0,0,0.10)]">
      <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-3">
        <Link href="/" aria-label="Ir al inicio" class="inline-flex items-center">
          <Logo />
        </Link>

        <div class="flex items-center gap-2">
          <button
            type="button"
            @click="$emit('openVacancies')"
            class="group relative inline-flex items-center justify-center
            rounded-full bg-sky-100 px-4 py-2
            text-[11px] font-extrabold tracking-widest text-black
            shadow-[0_10px_25px_rgba(0,0,0,0.25)] transition hover:bg-sky-300
            hover:text-white hover:shadow-[0_14px_35px_rgba(0,0,0,0.30)]
            hover:-translate-y-[1px] active:translate-y-0 active:scale-[0.98]
            focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70"
          >
            <span class="relative z-10">BOLSA DE TRABAJO</span>
            <span
              class="pointer-events-none absolute inset-0 -z-10
              rounded-full opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-45"
              style="background: radial-gradient(circle at 30% 30%, rgba(0,0,0,0.0), rgba(0,0,0,0.0), rgba(29,193,162,.35))"
            />
          </button>

          <div
            class="grid h-10 w-10 place-items-center rounded-full bg-black/10
            ring-1 ring-black/10 backdrop-blur-sm transition
            hover:bg-black/15 hover:ring-black/15 active:scale-[0.98]"
          >
            <MobileNavSheet :active="activeKey" />
          </div>
        </div>
      </div>
    </div>

    <!-- DESKTOP OVERLAY -->
    <div class="hidden md:block">
      <div class="mx-auto flex w-full max-w-7xl items-center px-6 py-6">
        <div class="ml-auto flex items-center gap-3 min-w-0">
          <!-- NavLinks puede ocupar, pero no debe empujar el botón fuera -->
          <NavLinks class="shrink min-w-0" variant="desktop" :active="activeKey" />

          <!-- Botón responsive: en md se vuelve compacto (icon-only) -->
          <button
            type="button"
            @click="$emit('openVacancies')"
            class="group relative inline-flex items-center justify-center rounded-full
            bg-sky-100 text-black transition
            shadow-[0_12px_30px_rgba(0,0,0,0.22)]
            hover:shadow-[0_16px_40px_rgba(0,0,0,0.28)]
            hover:-translate-y-[1px] active:translate-y-0 active:scale-[0.98]
            focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400/80
            focus-visible:ring-offset-2 focus-visible:ring-offset-white/10

            md:h-12 md:w-12 md:px-0 md:py-0
            lg:h-auto lg:w-auto lg:px-6 lg:py-5

            2xl:w-[200px] 2xl:text-xs"
            aria-label="Bolsa de trabajo"
          >
            <!-- Icono en md -->
            <span class="relative z-10 grid place-items-center lg:hidden">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                class="h-5 w-5" fill="none" stroke="currentColor"
                stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 6V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1"/>
                <rect x="4" y="6" width="16" height="14" rx="2"/>
                <path d="M8 11h8"/>
              </svg>
            </span>

            <!-- Texto en lg+ -->
            <span class="relative z-10 hidden lg:inline text-xs font-extrabold tracking-widest">
              BOLSA DE TRABAJO
            </span>

            <span
              class="pointer-events-none absolute inset-0 -z-10 rounded-full
              opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-40"
              style="background: radial-gradient(circle at 30% 30%, rgba(29,193,162,.45), transparent 55%)"
            />
          </button>
        </div>
      </div>
    </div>
  </header>
</template>
