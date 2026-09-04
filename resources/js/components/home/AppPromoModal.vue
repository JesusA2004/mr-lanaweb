<script setup lang="ts">
    import { onBeforeUnmount, onMounted, ref } from 'vue'
    import { ChevronLeft, ChevronRight } from 'lucide-vue-next'

    const open = ref(false)

    // Carrusel de promocionales: se detecta automáticamente cuántos
    // popup-XX existen en /img (y con qué extensión), en vez de una
    // lista fija. Así, agregar/quitar popup-04, popup-05, etc. (png,
    // jpg, jpeg o webp) no requiere tocar este componente.
    const popups = ref<string[]>([])
    const currentPopup = ref(0)

    const POPUP_EXTENSIONS = ['png', 'jpg', 'jpeg', 'webp']
    const MAX_POPUP_SLOTS = 12 // límite de seguridad, no un total fijo

    function imageExists(url: string): Promise<boolean> {
        return new Promise((resolve) => {
            const img = new Image()
            img.onload = () => resolve(true)
            img.onerror = () => resolve(false)
            img.src = url
        })
    }

    async function findPopupUrl(slotNumber: string): Promise<string | null> {
        const candidates = POPUP_EXTENSIONS.map((ext) => `/img/popup-${slotNumber}.${ext}`)
        const results = await Promise.all(
            candidates.map(async (url) => ((await imageExists(url)) ? url : null)),
        )
        return results.find((url): url is string => url !== null) ?? null
    }

    async function detectPopups(): Promise<string[]> {
        const found: string[] = []

        for (let i = 1; i <= MAX_POPUP_SLOTS; i++) {
            const slotNumber = String(i).padStart(2, '0')
            const url = await findPopupUrl(slotNumber)
            if (!url) break // ya no hay popup-XX consecutivo: fin de la lista
            found.push(url)
        }

        return found
    }

    function nextPopup() {
        currentPopup.value = (currentPopup.value + 1) % popups.value.length
    }

    function previousPopup() {
        currentPopup.value = (currentPopup.value - 1 + popups.value.length) % popups.value.length
    }

    function goToPopup(index: number) {
        currentPopup.value = index
    }

    function close() {
        open.value = false
    }

    function onKeydown(e: KeyboardEvent) {
        if (e.key === 'Escape') close()
        if (e.key === 'ArrowRight') nextPopup()
        if (e.key === 'ArrowLeft') previousPopup()
    }

    onMounted(async () => {
        popups.value = await detectPopups()

        // Si no hay ningún popup-XX en /img, no se muestra nada
        if (popups.value.length === 0) return

        // Siempre abrir en cada recarga
        open.value = true
        currentPopup.value = 0
        // Cerrar con ESC / navegar con flechas del teclado
        window.addEventListener('keydown', onKeydown)
        // Bloquear scroll mientras está abierto
        document.documentElement.classList.add('overflow-hidden')
    })

    onBeforeUnmount(() => {
        window.removeEventListener('keydown', onKeydown)
        document.documentElement.classList.remove('overflow-hidden')
    })

    // Si cierras el modal, re-habilita scroll
    const stopScrollWatcher = setInterval(() => {
        if (!open.value) document.documentElement.classList.remove('overflow-hidden')
    }, 100)

    onBeforeUnmount(() => clearInterval(stopScrollWatcher))
</script>

<template>
    <Teleport to="body">
        <Transition enter-active-class="transition ease-out duration-250"
        enter-from-class="opacity-0" enter-to-class="opacity-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="open" class="fixed inset-0 z-[9999]">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"
                @click="close"/>

                <!-- Modal -->
                <div class="relative flex min-h-dvh w-full items-center justify-center p-3 sm:p-4 md:p-6">
                    <Transition enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-3 scale-[0.98]"
                    enter-to-class="opacity-100 translate-y-0 scale-100"
                    leave-active-class="transition ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 scale-100"
                    leave-to-class="opacity-0 translate-y-2 scale-[0.98]">
                        <div v-if="open" class="relative w-fit max-w-[min(680px,100%)]
                        rounded-3xl overflow-hidden shadow-2xl ring-1 ring-white/10
                        bg-transparent max-h-[88dvh] sm:max-h-[90dvh]">
                            <!-- Botón cerrar (flotante) -->
                            <button type="button" class="absolute right-2 top-2
                            sm:right-3 sm:top-3 z-20 inline-flex h-9 w-9 sm:h-10 sm:w-10
                            items-center justify-center rounded-full bg-black/55
                            text-white text-base sm:text-lg ring-1 ring-white/15
                            backdrop-blur-md transition duration-200 hover:scale-105
                            hover:bg-black/70 active:scale-95 focus:outline-none
                            focus-visible:ring-2 focus-visible:ring-white/40"
                            @click="close" aria-label="Cerrar">
                                ✕
                            </button>

                            <!-- Carrusel de promocionales -->
                            <div class="relative flex items-center justify-center bg-transparent">
                                <Transition mode="out-in"
                                enter-active-class="transition ease-out duration-200"
                                enter-from-class="opacity-0"
                                enter-to-class="opacity-100"
                                leave-active-class="transition ease-in duration-150"
                                leave-from-class="opacity-100"
                                leave-to-class="opacity-0">
                                    <img :key="currentPopup" :src="popups[currentPopup]"
                                    class="block w-auto h-auto max-w-full
                                    max-h-[calc(88dvh-36px)] sm:max-h-[calc(90dvh-36px)]
                                    object-contain select-none"
                                    draggable="false"/>
                                </Transition>

                                <!-- Flecha izquierda -->
                                <button type="button" class="absolute left-1.5 sm:left-3
                                top-1/2 -translate-y-1/2 z-20 inline-flex h-9 w-9 sm:h-10
                                sm:w-10 items-center justify-center rounded-full bg-black/45
                                text-white ring-1 ring-white/15 backdrop-blur-md transition
                                duration-200 hover:scale-105 hover:bg-black/70 active:scale-95
                                cursor-pointer focus:outline-none focus-visible:ring-2
                                focus-visible:ring-white/40"
                                @click="previousPopup" aria-label="Promocional anterior">
                                    <ChevronLeft class="h-5 w-5 sm:h-6 sm:w-6" />
                                </button>

                                <!-- Flecha derecha -->
                                <button type="button" class="absolute right-1.5 sm:right-3
                                top-1/2 -translate-y-1/2 z-20 inline-flex h-9 w-9 sm:h-10
                                sm:w-10 items-center justify-center rounded-full bg-black/45
                                text-white ring-1 ring-white/15 backdrop-blur-md transition
                                duration-200 hover:scale-105 hover:bg-black/70 active:scale-95
                                cursor-pointer focus:outline-none focus-visible:ring-2
                                focus-visible:ring-white/40"
                                @click="nextPopup" aria-label="Siguiente promocional">
                                    <ChevronRight class="h-5 w-5 sm:h-6 sm:w-6" />
                                </button>
                            </div>

                            <!-- Indicadores (dots) -->
                            <div v-if="popups.length > 1" class="flex h-9 items-center
                            justify-center gap-2 bg-black/40">
                                <button v-for="(popup, index) in popups" :key="popup"
                                type="button" class="h-2 w-2 sm:h-2.5 sm:w-2.5 rounded-full
                                transition duration-200 cursor-pointer focus:outline-none"
                                :class="index === currentPopup
                                    ? 'bg-white scale-110'
                                    : 'bg-white/40 hover:bg-white/70'"
                                @click="goToPopup(index)"
                                :aria-label="`Ir al promocional ${index + 1}`"/>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
