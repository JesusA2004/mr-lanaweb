<script setup lang="ts">
    import { computed } from 'vue'
    import { Link, usePage } from '@inertiajs/vue3'

    type Active = 'servicios' | 'sucursales' | ''

    const props = withDefaults(
        defineProps<{
            active?: Active
            variant?: 'desktop' | 'mobile'
            onNavigate?: () => void
        }>(),
        { active: '', variant: 'desktop' }
    )

    const page = usePage()

    const activeKey = computed<Active>(() => {
        if (props.active) return props.active
        const url = (page.url || '').toLowerCase()
        if (url.startsWith('/sucursales')) return 'sucursales'
        if (url === '/' || url.startsWith('/index')) return 'servicios'
        return ''
    })

    /* ================= ICONOS TABLER (mejor elección visual) ================= */
    const icons = {
        services: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            class="h-full w-full" fill="none" stroke="currentColor"
            stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <path d="M8 7v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" />
            <rect x="3" y="7" width="18" height="14" rx="2" />
        </svg>`,
        branch: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            class="h-full w-full" fill="none" stroke="currentColor"
            stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 21s7-4.5 7-11a7 7 0 0 0-14 0c0 6.5 7 11 7 11z"/>
            <circle cx="12" cy="10" r="2"/>
        </svg>`,
        rocket: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            class="h-full w-full" fill="none" stroke="currentColor"
            stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 15l4 4"/>
            <path d="M14 5l5 5"/>
            <path d="M9 19c4-1 7-4 9-9"/>
        </svg>`,
        spark: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            class="h-full w-full" fill="none" stroke="currentColor"
            stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <rect x="4" y="6" width="16" height="12" rx="2"/>
            <path d="M4 10h16"/>
        </svg>`
    } as const

    const links = [
        { key: 'servicios', label: 'Servicios', href: '/', icon: icons.services },
        { key: 'sucursales', label: 'Sucursales', href: '/sucursales', icon: icons.branch },
        { key: '', label: 'Impulsa.N', href: '/impulsa-tu-negocio', icon: icons.rocket },
        { key: '', label: 'Impulsa.t', href: '/impulsat', icon: icons.spark },
    ] as const

    const isActive = (key: Active, href: string) => {
        const url = (page.url || '').toLowerCase()
        if (key) return key === activeKey.value
        return url.startsWith(href.toLowerCase())
    }

    /* ===================== DESKTOP ===================== */

    const desktopLinkClass = (key: Active, href: string) => {
        const active = isActive(key, href)
        return [
            'group relative inline-flex items-center gap-2',
            'px-1 py-1.5 text-neutral',
            //  TAMAÑO para MD
            'text-[10px] sm:text-[11px] md:text-xs lg:text-sm',
            //  TRACKING
            'tracking-[0.18em] md:tracking-[0.20em] lg:tracking-[0.22em]',
            'font-black uppercase',
            'transition-all duration-200',
            'hover:-translate-y-[1px]',
            active ? 'opacity-100' : 'opacity-90 hover:opacity-100',
        ].join(' ')
    }

    const desktopIconClass = (key: Active, href: string) => {
        const active = isActive(key, href)
        return [
            'inline-flex shrink-0',
            //  ICONO TAMBIÉN RESPONSIVE
            'h-[14px] w-[14px] sm:h-[16px] sm:w-[16px] lg:h-[18px] lg:w-[18px]',
            'transition-all duration-200',
            active ? 'text-emerald-700' : 'text-black/85 group-hover:text-emerald-700',
        ].join(' ')
    }

    const desktopUnderlineClass = (key: Active, href: string) => {
        const active = isActive(key, href)
        return [
            'absolute left-1/2 -bottom-[14px] -translate-x-1/2',
            'h-[3px] rounded-full',
            // COLOR QUE RESALTA MÁS
            'bg-emerald-500 shadow-[0_2px_8px_rgba(16,185,129,0.45)]',
            'transition-all duration-300',
            active ? 'w-full' : 'w-0 group-hover:w-full',
        ].join(' ')
    }

    /* ===================== MOBILE ===================== */
    const mobileItemClass = () =>
        'group flex w-full items-center gap-3 rounded-2xl px-3.5 py-3 text-sm font-semibold text-white/90 hover:bg-white/10'
</script>

<template>
    <!-- DESKTOP -->
    <nav v-if="variant === 'desktop'" class="relative flex items-center gap-8
    rounded-full px-6 py-3 bg-sky-100 backdrop-blur-md
    shadow-[0_10px_30px_rgba(0,0,0,0.08)] border border-white/60">
        <Link  v-for="l in links" :key="l.href" :href="l.href"
        :class="desktopLinkClass(l.key, l.href)">
            <span :class="desktopIconClass(l.key, l.href)" v-html="l.icon" />
            <span class="relative">
                {{ l.label }}
                <span :class="desktopUnderlineClass(l.key, l.href)" />
            </span>
        </Link>
    </nav>

    <!-- MOBILE -->
    <nav v-else class="space-y-2">
        <Link  v-for="l in links" :key="`m-${l.href}`" :href="l.href"
        :class="mobileItemClass()" @click="onNavigate?.()">
            <span class="h-5 w-5" v-html="l.icon" />
            <span class="flex-1">{{ l.label }}</span>
        </Link>
    </nav>
</template>
