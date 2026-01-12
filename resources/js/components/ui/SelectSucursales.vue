<script setup lang="ts">
    import { computed } from 'vue'
    import { SUCURSALES } from '@/lib/sucursales'
    
    const props = withDefaults(
      defineProps<{
        modelValue: string
        label?: string
        placeholder?: string
        error?: string
        disabled?: boolean
        required?: boolean
      }>(),
      {
        label: 'Sucursal',
        placeholder: 'Selecciona',
        disabled: false,
        required: false,
      }
    )
    
    const emit = defineEmits<{
      (e: 'update:modelValue', value: string): void
      (e: 'blur'): void
    }>()
    
    const value = computed({
      get: () => props.modelValue,
      set: (v: string) => emit('update:modelValue', v),
    })
    </script>
    
    <template>
      <div>
        <label
          v-if="label"
          class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]"
        >
          {{ label }}
          <span v-if="required" class="text-rose-600">*</span>
        </label>
    
        <select
          v-model="value"
          :disabled="disabled"
          @blur="emit('blur')"
          class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900
                 ring-1 ring-black/5 outline-none transition
                 hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60
                 disabled:opacity-60 disabled:cursor-not-allowed
                 text-[13px] sm:text-[14px] md:text-[15px]"
        >
          <option disabled value="">{{ placeholder }}</option>
          <option v-for="s in SUCURSALES" :key="s" :value="s">
            {{ s }}
          </option>
        </select>
    
        <p v-if="error" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">
          {{ error }}
        </p>
      </div>
    </template>
    