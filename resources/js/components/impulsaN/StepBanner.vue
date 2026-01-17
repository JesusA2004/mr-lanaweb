<script setup lang="ts">
    defineProps<{
        stepTitle: string
        stepSubtitle: string
        src: string
        alt: string
    }>()
</script>
    
<template>
    <div class="flex flex-col items-center text-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow">
        <div class="w-20 h-20 mb-4 flex items-center justify-center">
            <img :src="src" :alt="alt" class="max-w-full max-h-full object-contain" />
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ stepTitle }}</h3>
        <p class="text-gray-600 leading-relaxed">{{ stepSubtitle }}</p>
    </div>
</template>