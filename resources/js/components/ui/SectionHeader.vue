<script setup lang="ts">
    defineProps<{
      title: string
      subtitle?: string
      badge?: string
    }>()
</script>
    
<template>
    <div class="mb-10 text-center">
        <span
          v-if="badge"
          class="inline-block rounded-full bg-[#C2F6EC] px-4 py-1 text-sm font-semibold text-[#106A59]"
        >
          {{ badge }}
        </span>
    
        <h2 class="mt-4 text-3xl font-bold tracking-tight text-slate-900">
          {{ title }}
        </h2>
    
        <p v-if="subtitle" class="mt-3 text-slate-600 max-w-2xl mx-auto">
          {{ subtitle }}
        </p>
    </div>
</template>
    