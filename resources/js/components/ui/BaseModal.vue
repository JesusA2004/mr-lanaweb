<script setup lang="ts">
    import { computed, onBeforeUnmount, watch } from 'vue'
    
    type Props = {
      modelValue: boolean
      maxWidthClass?: string
      panelClass?: string
      closeOnBackdrop?: boolean
    }
    
    const props = withDefaults(defineProps<Props>(), {
      maxWidthClass: 'max-w-5xl',
      panelClass: '',
      closeOnBackdrop: true,
    })
    
    const emit = defineEmits<{
      (e: 'update:modelValue', value: boolean): void
      (e: 'close'): void
    }>()
    
    const isOpen = computed(() => props.modelValue)
    
    function close() {
      emit('update:modelValue', false)
      emit('close')
    }
    
    function onBackdropClick() {
      if (props.closeOnBackdrop) close()
    }
    
    function onKeydown(e: KeyboardEvent) {
      if (!isOpen.value) return
      if (e.key === 'Escape') close()
    }
    
    /**
     * Modal real:
     * - bloquea scroll del body
     * - el scroll vive en el overlay (no adentro del panel)
     */
    watch(
      () => isOpen.value,
      (v) => {
        if (typeof document === 'undefined') return
        document.body.style.overflow = v ? 'hidden' : ''
      },
      { immediate: true }
    )
    
    if (typeof window !== 'undefined') {
      window.addEventListener('keydown', onKeydown)
    }
    
    onBeforeUnmount(() => {
      if (typeof window !== 'undefined') window.removeEventListener('keydown', onKeydown)
      if (typeof document !== 'undefined') document.body.style.overflow = ''
    })
    </script>
    
    <template>
      <teleport to="body">
        <transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <!-- Overlay scrolleable (scroll del modal, NO de la página) -->
          <div
            v-if="isOpen"
            class="fixed inset-0 z-[9999] overflow-y-auto"
            aria-modal="true"
            role="dialog"
          >
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/60" @click="onBackdropClick" />
    
            <!-- Carril -->
            <div class="relative min-h-full px-3 pt-6 sm:pt-10
            pb-20 sm:pb-24 md:pb-28 lg:pb-32 flex items-start justify-center">
              <!-- Wrapper -->
              <div class="relative mx-auto w-[94vw] sm:w-[92vw] md:w-[90vw] lg:w-[88vw] xl:w-[86vw] 2xl:w-[82vw] px-2 sm:px-0">
                <div
                  :class="[
                    'relative mx-auto overflow-visible rounded-[22px] shadow-[0_30px_90px_rgba(0,0,0,0.45)] ring-1 ring-white/10 bg-white',
                    maxWidthClass,
                    panelClass,
                  ]"
                >
                  <!-- Close (X) -->
                  <button
                    type="button"
                    @click="close"
                    class="absolute right-3 top-3 z-50 grid h-9 w-9 place-items-center rounded-full bg-white/25 text-white backdrop-blur-sm transition hover:bg-white/35 active:scale-[0.98]"
                    aria-label="Cerrar"
                  >
                    <span class="text-xl leading-none">×</span>
                  </button>
    
                  <slot :close="close" />
                </div>
              </div>
            </div>
          </div>
        </transition>
      </teleport>
    </template>
    