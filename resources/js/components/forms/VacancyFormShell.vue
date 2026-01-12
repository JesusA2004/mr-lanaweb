<script setup lang="ts">
    import BaseModal from '@/components/ui/BaseModal.vue'
    
    defineProps<{
      modelValue: boolean
      title: string
      bullets: string[]
      bgImageDesktop?: string
    }>()
    
    const emit = defineEmits<{
      (e: 'update:modelValue', v: boolean): void
      (e: 'back'): void
    }>()
    </script>
    
    <template>
      <BaseModal
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        max-width-class="max-w-[1180px]"
        panel-class="bg-white"
      >
        <!-- Hero visible (desktop) -->
        <div
          class="hidden lg:block absolute inset-y-0 right-0 w-[42%]"
          :style="bgImageDesktop
            ? `background-image:
                linear-gradient(to left, rgba(255,255,255,0.88), rgba(255,255,255,0.30)),
                url(${bgImageDesktop});
               background-size: cover;
               background-position: center;`
            : `background-image: linear-gradient(to left, rgba(255,255,255,0.90), rgba(255,255,255,0.35));`"
        />
    
        <div class="relative">
          <!-- Header -->
          <div class="px-4 sm:px-6 lg:px-8 pt-4 sm:pt-5">
            <button
              type="button"
              @click="$emit('back')"
              class="inline-flex items-center gap-2
                     rounded-full bg-black/5 px-3 py-2
                     text-[12px] sm:text-[13px] font-semibold text-black/80
                     ring-1 ring-black/10 transition hover:bg-black/10"
            >
              <span class="text-base leading-none">←</span>
              Regresar
            </button>
          </div>
    
          <!-- Layout con altura fija (sin scroll) -->
          <div
            class="grid h-[calc(92vh-56px)] grid-cols-1 lg:grid-cols-2
                   gap-3 sm:gap-4 lg:gap-8
                   px-4 sm:px-6 lg:px-8 pb-4 sm:pb-6"
          >
            <!-- Col izquierda -->
            <div class="min-h-0 overflow-hidden">
              <h3
                class="mt-3 sm:mt-4 font-extrabold text-[#1879B3] tracking-tight
                       text-[clamp(18px,2.4vw,32px)]"
              >
                {{ title }}
              </h3>
    
              <ul
                class="mt-2 sm:mt-3 space-y-1 text-black/80 leading-snug
                       text-[clamp(11px,1.2vw,15px)]"
              >
                <li v-for="(b, i) in bullets" :key="i" class="flex gap-2">
                  <span class="mt-[6px] h-[5px] w-[5px] rounded-full bg-black/60 shrink-0" />
                  <span>{{ b }}</span>
                </li>
              </ul>
    
              <div class="mt-3 sm:mt-4 min-h-0 overflow-hidden">
                <slot />
              </div>
            </div>
    
            <!-- Col derecha (solo desktop) -->
            <div class="hidden lg:block" />
          </div>
        </div>
      </BaseModal>
    </template>
    