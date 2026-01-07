<script setup lang="ts">
    const props = defineProps<{
      href: string
      label: string
      size?: 'sm' | 'md' | 'lg'
    }>()

    const sizeClass: Record<'sm' | 'md' | 'lg', string> = {
      sm: 'px-5 py-2 text-sm',
      md: 'px-7 py-3 text-base',
      lg: 'px-10 py-4 text-lg',
    }
</script>

<template>
      <a
        :href="href"
        class="inline-flex items-center justify-center rounded-full bg-black font-extrabold text-white shadow-lg
               transition-transform duration-200 hover:bg-black/90 hover:scale-[1.02] active:scale-[0.98]"
        :class="sizeClass[props.size ?? 'md']"
      >
        {{ label }}
      </a>
</template>
