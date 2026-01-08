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
    
    /**
     * Tabler icons inline (SVG).
     * Sin deps extra. Puedes cambiarlos cuando quieras.
     */
    const icons = {
      services: `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 19v-14a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14" />
          <path d="M9 22v-4h6v4" />
          <path d="M8 7h8" /><path d="M8 11h8" />
        </svg>
      `,
      branch: `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 3v12" /><path d="M18 9a3 3 0 1 0-3-3" />
          <path d="M6 15a3 3 0 1 0 3 3" />
          <path d="M6 15c6 0 9-2 9-6" />
        </svg>
      `,
      rocket: `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 13a8 8 0 0 1 8-8h2a8 8 0 0 1 8 8v2a8 8 0 0 1-8 8h-2a8 8 0 0 1-8-8v-2z" />
          <path d="M9 15l6-6" />
          <path d="M10 10h.01" />
        </svg>
      `,
      spark: `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 2l1.5 5L18 9l-4.5 2L12 16l-1.5-5L6 9l4.5-2L12 2z" />
          <path d="M5 14l.8 2.6L8 18l-2.2 1.4L5 22l-.8-2.6L2 18l2.2-1.4L5 14z" />
        </svg>
      `,
    } as const
    
    const links = [
      { key: 'servicios' as const, label: 'Servicios', href: '/', icon: icons.services },
      { key: 'sucursales' as const, label: 'Sucursales', href: '/sucursales', icon: icons.branch },
      { key: '' as const, label: 'Impulsa.N', href: '/impulsa-tu-negocio', icon: icons.rocket },
      { key: '' as const, label: 'Impulsa.t', href: '/impulsat', icon: icons.spark },
    ] as const
    
    const desktopClass = (key: Active, href: string) => {
      const isActive =
        (key && key === activeKey.value) ||
        (!key && (page.url || '').toLowerCase().startsWith(href.toLowerCase()))
    
      return [
        'group relative inline-flex items-center gap-2 rounded-full px-4 py-2',
        'text-[11px] font-extrabold tracking-widest uppercase',
        'transition-all duration-200 ease-out',
        'backdrop-blur supports-[backdrop-filter]:bg-white/35',
        'shadow-[0_1px_0_rgba(0,0,0,0.05)]',
        isActive
          ? 'bg-white/70 text-black shadow-sm ring-1 ring-black/5'
          : 'text-black/80 hover:bg-white/60 hover:text-black hover:shadow-sm hover:-translate-y-[1px]',
      ].join(' ')
    }
    
    const mobileClass = (key: Active, href: string) => {
      const isActive =
        (key && key === activeKey.value) ||
        (!key && (page.url || '').toLowerCase().startsWith(href.toLowerCase()))
    
      return [
        'block w-full rounded-xl px-3 py-3 text-sm font-semibold transition',
        isActive ? 'bg-white/12 text-white' : 'text-white/85 hover:bg-white/10 hover:text-white',
      ].join(' ')
    }
    </script>
    
    <template>
      <!-- Desktop -->
      <nav v-if="variant === 'desktop'" class="flex items-center gap-2">
        <Link
          v-for="l in links"
          :key="l.href"
          :href="l.href"
          :class="desktopClass(l.key, l.href)"
        >
          <span class="grid h-7 w-7 place-items-center rounded-full bg-black/5 text-black/80 transition group-hover:bg-black/10">
            <span v-html="l.icon" />
          </span>
    
          <span class="relative">
            {{ l.label }}
            <!-- underline animado -->
            <span
              class="absolute -bottom-1 left-0 h-[2px] w-0 rounded-full bg-[#1DC1A2] transition-all duration-300 group-hover:w-full"
            />
          </span>
    
          <!-- glow sutil -->
          <span
            class="pointer-events-none absolute inset-0 -z-10 rounded-full opacity-0 blur-md transition-opacity duration-300 group-hover:opacity-30"
            style="background: radial-gradient(circle at 20% 20%, rgba(29,193,162,.35), transparent 60%)"
          />
        </Link>
      </nav>
    
      <!-- Mobile -->
      <nav v-else class="space-y-2">
        <Link
          v-for="l in links"
          :key="`m-${l.href}`"
          :href="l.href"
          :class="mobileClass(l.key, l.href)"
          @click="onNavigate?.()"
        >
          {{ l.label }}
        </Link>
      </nav>
    </template>
    