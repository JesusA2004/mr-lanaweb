<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import SectionHeader from '@/components/ui/SectionHeader.vue'
    import BranchesMap from '@/components/branches/BranchesMap.vue'
    import { branches } from '@/data/sucursales'

    const metaDescription =
    'Consulta las sucursales por estado: teléfono directo y ubicación en Google Maps. En desktop usa el cursor; en móvil toca un estado.'
</script>

<template>
    <Head title="Sucursales">
        <!-- SEO / Social básico (sin humo) -->
        <meta name="description" :content="metaDescription" />
        <meta property="og:title" content="Sucursales" />
        <meta property="og:description" :content="metaDescription" />
        <meta name="twitter:card" content="summary" />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden pt-20 sm:pt-24 md:pt-28 pb-6 sm:pb-10 md:pb-14">
            <div class="absolute inset-0 bg-slate-50 dark:bg-slate-950"></div>

            <div class="pointer-events-none absolute inset-x-0 top-0 z-10
            h-16 sm:h-20 md:h-24 bg-gradient-to-b from-slate-950/75
            via-slate-950/40 to-transparent
            dark:from-black/65 dark:via-black/35"/>

            <div class="pointer-events-none absolute -top-28 -left-28 h-[26rem] w-[26rem] rounded-full bg-sky-200/60 dark:bg-sky-500/15" />
            <div class="pointer-events-none absolute -bottom-32 -right-32 h-[30rem] w-[30rem] rounded-full bg-indigo-200/60 dark:bg-indigo-500/15" />

            <div class="pointer-events-none absolute inset-0 z-0
            bg-gradient-to-b from-white/40 via-transparent to-white/60
            dark:from-white/5 dark:to-white/5"/>

            <div class="relative z-20">
                <div class="mx-auto w-full max-w-[98rem] px-3 sm:px-4 md:px-6 lg:px-8 2xl:px-10">
                    <SectionHeader title="Sucursales"
                    align="left"/>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-2
                        rounded-full border border-slate-200 bg-white
                        px-3 py-1 text-xs font-semibold text-slate-800
                        shadow-sm dark:border-slate-800 dark:bg-slate-900
                        dark:text-slate-100">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                            Con presencia
                        </span>

                        <span class="inline-flex items-center gap-2
                        rounded-full border border-slate-200 bg-white
                        px-3 py-1 text-xs font-semibold text-slate-800
                        shadow-sm dark:border-slate-800
                        dark:bg-slate-900 dark:text-slate-100">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-600 opacity-25"></span>
                            Sin presencia
                        </span>

                        <span class="ml-auto hidden sm:inline-flex text-xs text-slate-500 dark:text-slate-400">
                            Tip: la dirección abre Google Maps
                        </span>
                    </div>
                </div>

                <div class="mt-5">
                    <BranchesMap :branches="branches" />
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
