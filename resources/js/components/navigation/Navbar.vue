<script setup lang="ts">
    import { computed } from 'vue'
    import { Link, usePage } from '@inertiajs/vue3'

    import Logo from '@/components/ui/Logo.vue'
    import NavLinks from '@/components/navigation/NavLinks.vue'
    import MobileNavSheet from '@/components/navigation/MobileNavSheet.vue'

    /**
     * Emit:
     * - openVacancies: abre el modal / sheet / acción de bolsa de trabajo
     */
    defineEmits<{ (e: 'openVacancies'): void }>()

    const page = usePage()

    // ActiveKey para resaltar links base (Servicios / Sucursales)
    const activeKey = computed<'servicios' | 'sucursales' | ''>(() => {
        const url = (page.url || '').toLowerCase()
        if (url.startsWith('/sucursales')) return 'sucursales'
        if (url === '/' || url.startsWith('/index')) return 'servicios'
        return ''
    })
</script>

<template>
    <!-- NAVBAR:
    - Móvil: sticky + barra con degradado (empuja el slider)
    - Desktop: overlay absoluto (NO empuja el slider) -->
    <header class="z-50 w-full sticky top-0 md:absolute md:inset-x-0 md:top-0">
        <!--
            BARRA MÓVIL (degradado):
            - En mobile con md:hidden -->
        <div class="md:hidden w-full bg-gradient-to-r from-[#55D86A] via-[#49D7B8]
        to-[#4DD7FF] shadow-[0_10px_25px_rgba(0,0,0,0.10)]">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-3">
                <!-- LOGO MÓVIL -->
                <Link href="/" aria-label="Ir al inicio" class="inline-flex items-center">
                    <Logo />
                </Link>

                <!-- ACCIONES MÓVIL (a la derecha) -->
                <div class="flex items-center gap-2">
                    <!-- BOTÓN BOLSA (móvil) -->
                    <button type="button" @click="$emit('openVacancies')"
                    class="group relative inline-flex items-center justify-center
                    rounded-full bg-black/90 px-4 py-2
                    text-[11px] font-extrabold tracking-widest text-white
                    shadow-[0_10px_25px_rgba(0,0,0,0.25)] transition hover:bg-black
                    hover:shadow-[0_14px_35px_rgba(0,0,0,0.30)]
                    hover:-translate-y-[1px] active:translate-y-0 active:scale-[0.98]
                    focus-visible:outline-none focus-visible:ring-2
                    focus-visible:ring-white/70">
                        <span class="relative z-10">BOLSA DE TRABAJO</span>

                        <!-- glow sutil de marca -->
                        <span class="pointer-events-none absolute inset-0 -z-10
                        rounded-full opacity-0 blur-md transition-opacity duration-300
                        group-hover:opacity-45"
                        style="background: radial-gradient(circle at 30% 30%, rgba(0,0,0,0.0), rgba(0,0,0,0.0), rgba(29,193,162,.35))"/>
                    </button>

                    <!-- HAMBURGER: lo envolvemos -->
                    <div class="grid h-10 w-10 place-items-center rounded-full bg-black/10
                    ring-1 ring-black/10 backdrop-blur-sm transition
                    hover:bg-black/15 hover:ring-black/15 active:scale-[0.98]">
                        <MobileNavSheet :active="activeKey" />
                    </div>
                </div>
            </div>
        </div>

        <!-- DESKTOP (overlay):
          - Sin fondo
          - Todo a la derecha: ml-auto + justify-end-->
        <div class="hidden md:block">
            <div class="mx-auto flex w-full max-w-7xl items-center px-6 py-6">
                <!-- IMPORTANTE: si no quieres logo en desktop, no lo pintamos.
                    Este ml-auto empuja TODO a la derecha. -->
                <div class="ml-auto flex items-center gap-3">
                <NavLinks class="shrink-0" variant="desktop" :active="activeKey" />

                <!-- Botón bolsa desktop -->
                <button
                    type="button"
                    @click="$emit('openVacancies')"
                    class="
                    group relative inline-flex items-center justify-center
                    rounded-full bg-black px-6 py-2
                    text-xs font-extrabold tracking-widest text-white
                    shadow-[0_12px_30px_rgba(0,0,0,0.22)]
                    transition
                    hover:shadow-[0_16px_40px_rgba(0,0,0,0.28)]
                    hover:-translate-y-[1px]
                    active:translate-y-0 active:scale-[0.98]
                    focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400/80
                    focus-visible:ring-offset-2 focus-visible:ring-offset-white/10
                    "
                >
                    <span class="relative z-10">BOLSA DE TRABAJO</span>

                    <span
                    class="
                        pointer-events-none absolute inset-0 -z-10 rounded-full
                        opacity-0 blur-md transition-opacity duration-300
                        group-hover:opacity-40
                    "
                    style="background: radial-gradient(circle at 30% 30%, rgba(29,193,162,.45), transparent 55%)"
                    />
                </button>
                </div>
            </div>
        </div>
    </header>
</template>
