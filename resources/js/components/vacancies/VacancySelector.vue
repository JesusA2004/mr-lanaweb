<script setup lang="ts">
    const emit = defineEmits<{
      (e: 'select', step: 'coord' | 'manager' | 'sub' | 'cred'): void
    }>()
    
    const items = [
      { key: 'coord', label: 'Coordinadora' },
      { key: 'manager', label: 'Gerente' },
      { key: 'sub', label: 'Subgerente' },
      { key: 'cred', label: 'Gestor de Crédito' },
    ] as const
    </script>
    
    <template>
      <div
        class="relative h-full w-full rounded-[2vw]"
        :style="{
          backgroundImage: `url(/img/bg-modal-vacancies.png)`,
          backgroundSize: 'cover',
          backgroundPosition: 'top',
          backgroundRepeat: 'no-repeat',
        }"
      >
        <!-- Overlay sutil para que el contenido siempre se lea -->
        <div class="absolute inset-0 bg-black/10" />
    
        <!-- IMPORTANTE: ya NO centramos vertical (justify-center), damos padding real arriba/abajo -->
        <div
          class="relative flex h-full w-full flex-col items-center justify-start px-4 sm:px-6
                 pt-6 sm:pt-8 md:pt-10
                 pb-10 sm:pb-14 md:pb-16 lg:pb-20"
        >
          <!-- Header imagen: NO se recorta (object-contain) -->
          <div class="w-full max-w-[820px] px-2 sm:px-4">
            <img
              src="/img/header-modal-vacancies.png"
              alt="Conoce las vacantes que tenemos disponibles"
              class="mx-auto block w-full object-contain
                     max-h-[110px] sm:max-h-[130px] md:max-h-[150px] lg:max-h-[170px] xl:max-h-[190px] 2xl:max-h-[210px]"
              loading="lazy"
            />
          </div>
    
          <!-- Botones: grandes y centrados -->
          <div class="mt-4 sm:mt-5 md:mt-6 w-full max-w-[780px] space-y-3 sm:space-y-4">
            <button
              v-for="it in items"
              :key="it.key"
              type="button"
              @click="emit('select', it.key)"
              class="w-full rounded-full bg-white text-black shadow-[0_14px_35px_rgba(0,0,0,0.25)]
                     transition hover:-translate-y-[1px] hover:shadow-[0_18px_45px_rgba(0,0,0,0.30)]
                     active:translate-y-0 active:scale-[0.99]
                     py-4 sm:py-5 md:py-6"
            >
              <span
                class="block font-extrabold tracking-tight
                       text-[18px] sm:text-[22px] md:text-[26px] lg:text-[34px] xl:text-[40px] 2xl:text-[44px]"
              >
                {{ it.label }}
              </span>
            </button>
          </div>
        </div>
      </div>
    </template>
    