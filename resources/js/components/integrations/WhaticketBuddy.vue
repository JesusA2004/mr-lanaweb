<script setup lang="ts">
    import { computed, nextTick, onBeforeUnmount, onMounted, ref } from 'vue'

    declare global {
        interface Window {
            __WTT_BUDDY_ANCHOR__?: { x: number; y: number }
        }
    }

    const props = withDefaults(
        defineProps<{
            srcDesktop?: string
            srcMobile?: string
            widthDesktop?: number
            widthMobile?: number
            edge?: number

            // Punto del círculo en % (AJUSTABLES)
            anchorXDesktop?: number
            anchorYDesktop?: number
            anchorXMobile?: number
            anchorYMobile?: number
        }>(),
        {
            srcDesktop: '/img/footer/bg-whabutton.png',
            srcMobile: '/img/footer/bg-whaticket-mobile.png',
            widthDesktop: 190,
            widthMobile: 92,
            edge: 18,
            // Ajuste inicial (tú lo afinas)
            anchorXDesktop: 82,
            anchorYDesktop: 60,
            anchorXMobile: 55,
            anchorYMobile: 68,
        }
    )

    const imgRef = ref<HTMLImageElement | null>(null)
    const anchorRef = ref<HTMLDivElement | null>(null)
    const isMob = ref(false)

    function isMobile() {
        return window.matchMedia('(max-width: 1023px)').matches
    }

    const src = computed(() => (isMob.value ? props.srcMobile : props.srcDesktop))
    const width = computed(() => (isMob.value ? props.widthMobile : props.widthDesktop))

    const style = ref<Record<string, string>>({
        position: 'fixed',
        zIndex: '9998',
        pointerEvents: 'none',
        bottom: `${props.edge}px`,
        right: `${props.edge}px`,
        left: 'auto',
        width: `${props.widthDesktop}px`,
    })

    const anchorStyle = computed(() => {
        const x = isMob.value ? props.anchorXMobile : props.anchorXDesktop
        const y = isMob.value ? props.anchorYMobile : props.anchorYDesktop
        return {
            left: `${x}%`,
            top: `${y}%`,
            transform: 'translate(-50%, -50%)',
        } as Record<string, string>
    })

    function computeAnchorFromRealAnchor() {
        const el = anchorRef.value
        if (!el) return

        const rect = el.getBoundingClientRect()
        const next = {
            x: rect.left + rect.width / 2,
            y: rect.top + rect.height / 2,
        }

        // guarda anchor
        window.__WTT_BUDDY_ANCHOR__ = next

        //  avisa al widget que el anchor cambió
        window.dispatchEvent(new CustomEvent('wtt-buddy-anchor-updated', { detail: next }))
    }


    async function update() {
        isMob.value = isMobile()
        style.value = {
            position: 'fixed',
            zIndex: '9998',
            pointerEvents: 'none',
            bottom: `${props.edge}px`,
            right: `${props.edge}px`,
            left: 'auto',
            width: `${width.value}px`,
        }
        await nextTick()
        computeAnchorFromRealAnchor()
    }
    onMounted(() => {
        const onResize = () => update()
        const onScroll = () => computeAnchorFromRealAnchor()
        window.addEventListener('resize', onResize, { passive: true })
        window.addEventListener('scroll', onScroll, { passive: true })
        update()
        onBeforeUnmount(() => {
            window.removeEventListener('resize', onResize as any)
            window.removeEventListener('scroll', onScroll as any)
        })
    })
    onBeforeUnmount(() => {})
</script>

<template>
    <div :style="style" aria-hidden="true">
        <div class="relative">
        <img ref="imgRef" :src="src" class="w-full h-auto select-none"
        loading="lazy" draggable="false"
        @load="computeAnchorFromRealAnchor()"/>

        <!-- Punto EXACTO del círculo (ajusta % si hace falta) -->
        <div ref="anchorRef" class="absolute h-3 w-3 rounded-full"
        :style="anchorStyle"/>
        </div>
    </div>
</template>
