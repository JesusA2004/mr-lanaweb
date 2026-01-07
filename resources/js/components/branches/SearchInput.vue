<script setup lang="ts">
    const props = defineProps<{ modelValue: string; placeholder?: string }>()
    const emit = defineEmits<{ (e: 'update:modelValue', v: string): void }>()
    </script>
    
    <template>
      <input
        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40"
        :placeholder="placeholder ?? 'Buscar por ciudad o estado...'"
        :value="modelValue"
        @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      />
    </template>
    