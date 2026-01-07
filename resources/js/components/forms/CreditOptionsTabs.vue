<script setup lang="ts">
    const props = defineProps<{
      modelValue: 'diario' | 'semanal'
    }>()
    
    const emit = defineEmits<{
      (e: 'update:modelValue', v: 'diario' | 'semanal'): void
    }>()
    
    function set(v: 'diario' | 'semanal') {
      emit('update:modelValue', v)
    }
    </script>
    
    <template>
      <div class="inline-flex rounded-2xl border border-slate-200 bg-white p-1">
        <button
          type="button"
          class="rounded-2xl px-5 py-2 text-sm font-semibold transition"
          :class="modelValue === 'diario' ? 'bg-[#1DC1A2] text-white' : 'text-slate-700 hover:bg-slate-50'"
          @click="set('diario')"
        >
          Diario
        </button>
    
        <button
          type="button"
          class="rounded-2xl px-5 py-2 text-sm font-semibold transition"
          :class="modelValue === 'semanal' ? 'bg-[#1DC1A2] text-white' : 'text-slate-700 hover:bg-slate-50'"
          @click="set('semanal')"
        >
          Semanal
        </button>
      </div>
    </template>
    