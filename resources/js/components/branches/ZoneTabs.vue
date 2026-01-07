<script setup lang="ts">
    import { computed } from 'vue'
    
    const props = defineProps<{
      modelValue: string
      zones: { key: string; label: string }[]
    }>()
    
    const emit = defineEmits<{ (e: 'update:modelValue', v: string): void }>()
    
    const active = computed(() => props.modelValue)
    </script>
    
    <template>
      <div class="flex flex-wrap gap-2">
        <button
          v-for="z in zones"
          :key="z.key"
          type="button"
          class="rounded-2xl border px-4 py-2 text-sm font-semibold transition"
          :class="active === z.key ? 'border-[#1DC1A2] bg-[#C2F6EC]/50 text-[#106A59]' : 'border-slate-200 bg-white text-slate-800 hover:bg-slate-50'"
          @click="emit('update:modelValue', z.key)"
        >
          {{ z.label }}
        </button>
      </div>
    </template>
    