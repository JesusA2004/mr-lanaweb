<script setup lang="ts">
    import { computed, onBeforeUnmount, onMounted, ref } from 'vue'
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

    const sheetOpen = ref(false)
    let obs: MutationObserver | null = null
    function computeSheetOpen() {
        const openByState = !!document.querySelector('[data-state="open"]')
        const scrollLocked = document.body.hasAttribute('data-scroll-locked')
        sheetOpen.value = openByState || scrollLocked
    }

    onMounted(() => {
        computeSheetOpen()
        obs = new MutationObserver(() => computeSheetOpen())
        obs.observe(document.documentElement, { attributes: true, subtree: true, attributeFilter: ['data-state'] })
        obs.observe(document.body, { attributes: true })
    })

    onBeforeUnmount(() => {
        if (obs) obs.disconnect()
        obs = null
    })
</script>

<template>
    <!--  Cuando el sheet está abierto, el navbar baja z para NO taparlo -->
    <header :class="[ 'sticky top-0 w-full md:absolute md:inset-x-0 md:top-0',
        sheetOpen ? 'z-[10]' : 'z-[120]']">
        <!-- MOBILE BAR (NO TOCAR) -->
        <div class="md:hidden w-full bg-gradient-to-r from-[#55D86A]
        via-[#49D7B8] shadow-[0_10px_25px_rgba(0,0,0,0.10)]">
            <div class="mx-auto flex w-full max-w-7xl items-center
            justify-between px-4 py-3">
                <Link href="/" aria-label="Ir al inicio"
                class="inline-flex items-center">
                    <Logo />
                </Link>

                <div class="flex items-center gap-2">
                    <button type="button" @click="$emit('openVacancies')"
                    class="group relative inline-flex items-center justify-center
                    rounded-full bg-sky-100 px-4 py-2
                    text-[11px] font-extrabold tracking-widest text-black
                    shadow-[0_10px_25px_rgba(0,0,0,0.25)]
                    transition hover:bg-sky-300 hover:text-white
                    hover:shadow-[0_14px_35px_rgba(0,0,0,0.30)]
                    hover:-translate-y-[1px] active:translate-y-0
                    active:scale-[0.98] focus-visible:outline-none
                    focus-visible:ring-2 focus-visible:ring-white/70">
                        <span class="relative z-10">BOLSA DE TRABAJO</span>
                    </button>

                    <div class="grid h-10 w-10 place-items-center rounded-full
                    bg-black/10 ring-1 ring-black/10 backdrop-blur-sm
                    transition hover:bg-black/15 hover:ring-black/15
                    active:scale-[0.98]">
                        <MobileNavSheet :active="activeKey" />
                    </div>
                </div>
            </div>
        </div>

        <!-- DESKTOP -->
        <div class="hidden md:block">
            <div class="mx-auto w-full max-w-7xl px-6">
                <div class="flex w-full items-center justify-end gap-3 py-3 flex-nowrap min-w-0">
                    <div class="min-w-0 flex-1">
                        <div class="min-w-0 w-full overflow-x-auto
                        whitespace-nowrap [scrollbar-width:none] [-ms-overflow-style:none]">
                            <div class="[&::-webkit-scrollbar]:hidden">
                                <NavLinks class="inline-flex min-w-max align-middle" variant="desktop" :active="activeKey" />
                            </div>
                        </div>
                    </div>

                    <button type="button" @click="$emit('openVacancies')"
                    class="group relative inline-flex shrink-0 items-center
                    justify-center rounded-full bg-black/80 text-white
                    shadow-[0_10px_24px_rgba(0,0,0,0.22)] transition
                    hover:bg-black/90 hover:shadow-[0_14px_34px_rgba(0,0,0,0.26)]
                    hover:-translate-y-[1px] active:translate-y-0
                    active:scale-[0.98] focus-visible:outline-none
                    focus-visible:ring-2 focus-visible:ring-emerald-400/80
                    focus-visible:ring-offset-2 focus-visible:ring-offset-transparent
                    md:h-10 md:w-10 md:px-0
                    lg:h-auto lg:w-auto lg:px-5 lg:py-2.5
                    2xl:w-[190px]" aria-label="Bolsa de trabajo">
                        <span class="relative z-10 hidden lg:inline text-[11px] font-extrabold tracking-widest">
                            BOLSA DE TRABAJO
                        </span>
                        <span class="relative z-10 grid place-items-center lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                class="h-5 w-5" fill="none" stroke="currentColor"
                                stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="6" width="16" height="14" rx="2"/>
                                <path d="M8 11h8"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>
