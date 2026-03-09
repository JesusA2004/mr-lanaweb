<script setup lang="ts">
    import { onBeforeUnmount, onMounted, ref } from 'vue'

    const open = ref(false)

    function close() {
        open.value = false
    }

    function onKeydown(e: KeyboardEvent) {
        if (e.key === 'Escape') close()
    }

    onMounted(() => {
        // Siempre abrir en cada recarga
        open.value = true
        // Cerrar con ESC
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
                        <div v-if="open" class="relative w-full max-w-[680px] rounded-3xl
                        overflow-hidden shadow-2xl ring-1 ring-white/10 bg-transparent
                        max-h-[88dvh] sm:max-h-[90dvh]">
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

                            <!-- Solo la imagen -->
                            <img src="/img/popup-01.jpg"
                            class="block w-full h-auto select-none"
                            draggable="false"/>
                        </div>
                    </Transition>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
