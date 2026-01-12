<!-- resources/js/components/ui/NumericInput.vue -->
<script setup lang="ts">
    import { computed } from 'vue'
    
    const props = defineProps<{
      modelValue: string | number
      label?: string
      placeholder?: string
      error?: string
      maxLen?: number
      allowDecimal?: boolean
    }>()
    
    const emit = defineEmits<{
      (e: 'update:modelValue', value: string): void
    }>()
    
    function sanitize(raw: string) {
      let v = raw
    
      if (props.allowDecimal) {
        // deja solo dígitos y un punto
        v = v.replace(/[^\d.]/g, '')
        const parts = v.split('.')
        if (parts.length > 2) v = parts[0] + '.' + parts.slice(1).join('')
      } else {
        v = v.replace(/\D/g, '')
      }
    
      if (props.maxLen && props.maxLen > 0) v = v.slice(0, props.maxLen)
      return v
    }
    
    const value = computed({
      get: () => String(props.modelValue ?? ''),
      set: (v: string) => emit('update:modelValue', sanitize(v)),
    })
    
    function onInput(e: Event) {
      const el = e.target as HTMLInputElement
      const clean = sanitize(el.value)
      if (el.value !== clean) el.value = clean
      emit('update:modelValue', clean)
    }
    </script>
    
    <template>
      <div>
        <label v-if="label" class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">
          {{ label }}
        </label>
    
        <input
          :value="value"
          @input="onInput"
          inputmode="numeric"
          autocomplete="off"
          class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3
                 text-slate-900 placeholder:text-slate-500
                 ring-1 ring-black/5 outline-none transition
                 hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60
                 text-[13px] sm:text-[14px] md:text-[15px]"
          :placeholder="placeholder"
        />
    
        <p v-if="error" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">
          {{ error }}
        </p>
      </div>
    </template>
    