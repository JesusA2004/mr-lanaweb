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
    
    /** Tabler Icons (SVG inline) */
    const icons = {
      services: `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 21h18" />
        <path d="M5 21V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v14" />
        <path d="M9 21v-6h6v6" />
        <path d="M10 9h4" />
        <path d="M10 12h4" />
      </svg>
      `,
      branch: `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 3v12" />
        <path d="M6 15a3 3 0 1 0 3 3" />
        <path d="M18 9a3 3 0 1 0-3-3" />
        <path d="M6 15c6 0 9-2 9-6" />
      </svg>
      `,
      rocket: `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 13a8 8 0 0 1 8-8h2a8 8 0 0 1 8 8v2a8 8 0 0 1-8 8h-2a8 8 0 0 1-8-8v-2z" />
        <path d="M9 15l6-6" />
        <path d="M10 10h.01" />
      </svg>
      `,
      spark: `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2l1.6 5.2L18 9l-4.4 2-1.6 5-1.6-5L6 9l4.4-1.8L12 2z" />
        <path d="M5 14l.9 2.8L8 18l-2.1 1.2L5 22l-.9-2.8L2 18l2.1-1.2L5 14z" />
      </svg>
      `,
    } as const
    
    const links = [
      { key: 'servicios' as const, label: 'Servicios', href: '/', icon: icons.services },
      { key: 'sucursales' as const, label: 'Sucursales', href: '/sucursales', icon: icons.branch },
      { key: '' as const, label: 'Impulsa.N', href: '/impulsa-tu-negocio', icon: icons.rocket },
      { key: '' as const, label: 'Impulsa.t', href: '/impulsat', icon: icons.spark },
    ] as const
    
    const isActive = (key: Active, href: string) => {
      const url = (page.url || '').toLowerCase()
      if (key) return key === activeKey.value
      return url.startsWith(href.toLowerCase())
    }
    
    /** Accesibilidad teclado */
    const focusClass =
      'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white/70'
    
    /** Rail discreto para que se lean en fondos “ruidosos”. Si lo odias: bórralo y listo. */
    const desktopRailClass = [
      'flex items-center gap-4',
      'rounded-full px-3 py-2',
      'bg-white/60',                 // NO glass: solo un velo claro
      'shadow-[0_12px_34px_rgba(0,0,0,0.14)]',
      'ring-1 ring-black/5',
    ].join(' ')
    
    const desktopLinkClass = (key: Active, href: string) => {
      const active = isActive(key, href)
      return [
        'group relative inline-flex items-center gap-2',
        'px-2.5 py-2',
        'text-[11px] font-extrabold tracking-[0.20em] uppercase',
        'transition-transform duration-200 ease-out',
        'hover:-translate-y-[1px] active:translate-y-0',
        active ? 'text-black' : 'text-black/70 hover:text-black',
      ].join(' ')
    }
    
    const desktopIconClass = (key: Active, href: string) => {
      const active = isActive(key, href)
      return [
        'grid h-7 w-7 place-items-center rounded-full',
        'transition-transform duration-200 ease-out',
        'group-hover:scale-[1.06] group-active:scale-[0.98]',
        active ? 'text-emerald-600' : 'text-black/60 group-hover:text-emerald-600',
      ].join(' ')
    }
    
    const desktopUnderlineClass = (key: Active, href: string) => {
      const active = isActive(key, href)
      return [
        'pointer-events-none absolute left-1/2 -bottom-[2px] h-[2px] -translate-x-1/2 rounded-full',
        'bg-emerald-500',
        'transition-all duration-300 ease-out',
        active ? 'w-[85%] opacity-100' : 'w-0 opacity-70 group-hover:w-[85%]',
      ].join(' ')
    }
    
    /** Mobile (igual que traías: usable y dark) */
    const mobileItemClass = (key: Active, href: string) => {
      const active = isActive(key, href)
      return [
        'group flex w-full items-center gap-3 rounded-2xl px-3.5 py-3',
        'text-sm font-semibold',
        'transition-all duration-200 ease-out',
        active
          ? 'bg-white/12 text-white shadow-[0_10px_24px_rgba(0,0,0,0.25)]'
          : 'text-white/85 hover:bg-white/10 hover:text-white',
      ].join(' ')
    }
    
    const mobileIconClass = (key: Active, href: string) => {
      const active = isActive(key, href)
      return [
        'grid h-10 w-10 place-items-center rounded-2xl',
        'transition-transform duration-200 ease-out',
        active ? 'bg-white/12 text-white' : 'bg-white/8 text-white/85 group-hover:bg-white/12 group-hover:text-white',
        'group-hover:scale-[1.03] group-active:scale-[0.98]',
      ].join(' ')
    }
    </script>
    
    <template>
      <!-- DESKTOP -->
      <nav v-if="variant === 'desktop'" class="flex items-center gap-2">
        <div :class="desktopRailClass">
          <Link
            v-for="l in links"
            :key="l.href"
            :href="l.href"
            :class="[desktopLinkClass(l.key, l.href), focusClass]"
          >
            <span :class="desktopIconClass(l.key, l.href)">
              <span class="h-4 w-4" v-html="l.icon" />
            </span>
    
            <span class="relative leading-none">
              {{ l.label }}
              <span :class="desktopUnderlineClass(l.key, l.href)" />
            </span>
          </Link>
        </div>
      </nav>
    
      <!-- MOBILE -->
      <nav v-else class="space-y-2">
        <Link
          v-for="l in links"
          :key="`m-${l.href}`"
          :href="l.href"
          :class="[mobileItemClass(l.key, l.href), focusClass]"
          @click="onNavigate?.()"
        >
          <span :class="mobileIconClass(l.key, l.href)">
            <span class="h-5 w-5" v-html="l.icon" />
          </span>
    
          <span class="flex-1">{{ l.label }}</span>
    
          <span class="text-white/35 transition group-hover:text-white/70 group-hover:translate-x-[2px]">
            ›
          </span>
        </Link>
      </nav>
    </template>
    