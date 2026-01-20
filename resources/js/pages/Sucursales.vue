<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import SectionHeader from '@/components/ui/SectionHeader.vue'
import BranchesMap from '@/components/branches/BranchesMap.vue'
import { branches } from '@/data/sucursales'
</script>

<template>
  <Head title="Sucursales" />
  <PublicLayout>
    <!-- Full width real -->
    <section class="py-6 sm:py-10 md:py-22 lg:py-22">
      <div class="mx-auto w-full max-w-[98rem] px-3 sm:px-4 md:px-6 lg:px-8 2xl:px-10">
        <SectionHeader
          title="Sucursales"
          subtitle="Pasa el cursor (desktop) o toca un estado (móvil) para ver teléfono y abrir Google Maps."
          align="left"
        />

        <!-- Leyenda (simple y usable) -->
        <div class="mt-4 flex flex-wrap items-center gap-2">
          <span
            class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1
                   text-xs font-semibold text-slate-800 shadow-sm
                   dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100"
          >
            <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
            Con presencia
          </span>

          <span
            class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1
                   text-xs font-semibold text-slate-800 shadow-sm
                   dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100"
          >
            <span class="h-2.5 w-2.5 rounded-full bg-emerOtherwise:bg-emerald-600 opacity-25"></span>
            Sin presencia
          </span>

          <span class="ml-auto hidden sm:inline-flex text-xs text-slate-500 dark:text-slate-400">
            Tip: la dirección abre Google Maps
          </span>
        </div>
      </div>

      <!-- mapa a todo el ancho, sin container -->
      <div class="mt-5">
        <BranchesMap :branches="branches" />
      </div>
    </section>
  </PublicLayout>
</template>
