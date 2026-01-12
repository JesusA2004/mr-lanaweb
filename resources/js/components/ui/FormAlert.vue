<!-- resources/js/components/ui/FormAlert.vue -->
<script setup lang="ts">
    const props = defineProps<{
      title?: string
      message: string
      variant?: 'error' | 'success' | 'info'
    }>()
    
    const variants = {
      error: 'bg-rose-50 text-rose-800 ring-1 ring-rose-200',
      success: 'bg-emerald-50 text-emerald-800 ring-1 ring-emerald-200',
      info: 'bg-sky-50 text-sky-800 ring-1 ring-sky-200',
    } as const
    </script>
    
    <template>
      <div
        class="rounded-2xl px-4 py-3 text-sm font-semibold"
        :class="variants[variant ?? 'error']"
        role="alert"
      >
        <div v-if="title" class="mb-1 font-extrabold">{{ title }}</div>
        <div class="text-[13px] leading-snug">{{ message }}</div>
      </div>
    </template>
    