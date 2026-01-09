<script setup lang="ts">
    defineProps<{ href?: string }>()
</script>

<template>
    <a :href="href ?? '/'" class="inline-flex transition-transform duration-200 hover:scale-[1.2] active:scale-[0.98]">
        <img src="/img/logo-mr-lana.png" alt="Mr Lana"
            class="h-15 w-auto object-contain lg:h-16 xl:h-[100px]"
            loading="eager" draggable="false" />
    </a>
</template>
