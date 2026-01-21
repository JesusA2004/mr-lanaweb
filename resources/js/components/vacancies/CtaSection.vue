<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    imgMobile: string
    imgDesktop: string
    alt?: string
    buttonText?: string
  }>(),
  {
    alt: 'Banner',
    buttonText: 'Bolsa de trabajo',
  }
)

const emit = defineEmits<{
  (e: 'click'): void
}>()
</script>

<template>
  <section class="relative w-full">
    <!-- MOBILE -->
    <img
      :src="imgMobile"
      :alt="alt"
      class="block w-full h-auto select-none md:hidden"
      draggable="false"
    />

    <!-- DESKTOP -->
    <img
      :src="imgDesktop"
      :alt="alt"
      class="hidden w-full h-auto select-none md:block"
      draggable="false"
    />

    <!-- Botón overlay -->
    <div
      class="absolute left-4 bottom-4
             sm:left-6 sm:bottom-6
             md:left-10 md:bottom-8
             lg:left-12 lg:bottom-10
             xl:left-14 xl:bottom-12
             2xl:left-16 2xl:bottom-14"
    >
      <button
        type="button"
        @click="emit('click')"
        class="inline-flex items-center justify-center rounded-full
               bg-white/95 px-6 py-3 font-extrabold tracking-wide
               text-emerald-700 shadow-[0_18px_40px_-18px_rgba(0,0,0,0.55)]
               backdrop-blur-sm transition duration-300
               hover:-translate-y-0.5 hover:bg-white hover:shadow-[0_24px_60px_-20px_rgba(0,0,0,0.65)]
               focus:outline-none focus-visible:ring-4 focus-visible:ring-emerald-400/40
               text-sm sm:text-base md:text-[15px]
               min-w-[190px] sm:min-w-[210px] md:min-w-[230px]"
      >
        {{ buttonText }}
      </button>
    </div>
  </section>
</template>
