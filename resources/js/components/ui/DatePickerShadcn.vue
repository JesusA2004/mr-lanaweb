<!-- resources/js/components/ui/DatePickerShadcn.vue -->
<script setup lang="ts">
    import { computed, ref, watch } from 'vue'
    import { format, parseISO } from 'date-fns'
    
    // shadcn-vue
    import { Calendar } from '@/components/ui/calendar'
    import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
    
    // IMPORTANTE: tipos/funciones correctas para Calendar (reka/shadcn)
    import { parseDate, type DateValue, type CalendarDate } from '@internationalized/date'
    
    const props = defineProps<{
      modelValue: string // YYYY-MM-DD
      label?: string
      placeholder?: string
      error?: string
    }>()
    
    const emit = defineEmits<{
      (e: 'update:modelValue', value: string): void
    }>()
    
    // Controlamos el Popover para poder cerrarlo al seleccionar
    const open = ref(false)
    
    // Calendar trabaja con DateValue (CalendarDate)
    const picked = computed<DateValue | undefined>({
      get() {
        if (!props.modelValue) return undefined
        try {
          // parseDate espera YYYY-MM-DD
          return parseDate(props.modelValue)
        } catch {
          return undefined
        }
      },
      set(v) {
        if (!v) return
        // v.toString() devuelve YYYY-MM-DD
        emit('update:modelValue', v.toString())
        open.value = false // cerrar al seleccionar
      },
    })
    
    const pretty = computed(() => {
      if (!props.modelValue) return props.placeholder ?? 'Selecciona fecha'
      try {
        return format(parseISO(props.modelValue), 'dd/MM/yyyy')
      } catch {
        return props.placeholder ?? 'Selecciona fecha'
      }
    })
    </script>
    
    <template>
      <div>
        <label
          v-if="label"
          class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]"
        >
          {{ label }}
        </label>
    
        <Popover v-model:open="open">
          <PopoverTrigger as-child>
            <button
              type="button"
              class="mt-1 w-full text-left rounded-2xl bg-slate-100/70 px-4 py-3
                     text-slate-900 ring-1 ring-black/5 outline-none transition
                     hover:ring-black/10 hover:bg-slate-100
                     focus:ring-2 focus:ring-emerald-400/60
                     text-[13px] sm:text-[14px] md:text-[15px]"
            >
              {{ pretty }}
            </button>
          </PopoverTrigger>
    
          <PopoverContent class="z-[10050] w-auto p-0" align="start">
            <!-- lo correcto es v-model con DateValue -->
            <Calendar v-model="picked" />
          </PopoverContent>
        </Popover>
    
        <p v-if="error" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">
          {{ error }}
        </p>
      </div>
    </template>
    