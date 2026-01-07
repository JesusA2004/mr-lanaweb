<script setup lang="ts">
    import type { Branch } from '@/data/sucursales'
    
    const props = defineProps<{
      modelValue: string
      branches: Branch[]
      placeholder?: string
    }>()
    
    const emit = defineEmits<{
      (e: 'update:modelValue', v: string): void
    }>()
    </script>
    
    <template>
      <select
        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40"
        :value="modelValue"
        @change="emit('update:modelValue', ($event.target as HTMLSelectElement).value)"
      >
        <option value="">{{ placeholder ?? 'Selecciona sucursal' }}</option>
        <option v-for="b in branches" :key="b.id" :value="b.id">
          {{ b.name }} ({{ b.city }}, {{ b.state }})
        </option>
      </select>
    </template>
    