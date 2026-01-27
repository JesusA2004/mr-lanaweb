<!-- resources/js/components/ui/DatePickerShadcn.vue -->
<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { format, parseISO } from 'date-fns'

// shadcn-vue
import { Calendar } from '@/components/ui/calendar'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'

import {
  parseDate,
  today,
  getLocalTimeZone,
  type DateValue,
} from '@internationalized/date'

const props = defineProps<{
  modelValue: string // YYYY-MM-DD
  label?: string
  placeholder?: string
  error?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

const open = ref(false)
const tz = getLocalTimeZone()

// ===== Regla de negocio: solo >= 18 =====
const maxDob = computed<DateValue>(() => today(tz).subtract({ years: 18 }))

// ===== picked (valor real) =====
const picked = computed<DateValue | undefined>({
  get() {
    if (!props.modelValue) return undefined
    try {
      return parseDate(props.modelValue)
    } catch {
      return undefined
    }
  },
  set(v) {
    if (!v) return
    emit('update:modelValue', v.toString())
    open.value = false
  },
})

// ===== placeholder/view (mes visible) =====
// OJO: en tu wrapper `placeholder` NO está tipado como DateValue.
// Runtime acepta DateValue, pero TS no. Lo manejamos como any.
const view = ref<any>(parseDate(`${(maxDob.value as any).year}-01-01`))

function pad2(n: number) {
  return String(n).padStart(2, '0')
}

function safeParse(v: string): DateValue {
  try {
    return parseDate(v)
  } catch {
    return maxDob.value
  }
}

function makeViewDate(y: number, m: number): DateValue {
  return parseDate(`${y}-${pad2(m)}-01`)
}

// Cuando abres o cambia el valor: centra el calendario en la fecha seleccionada o en maxDob
watch(
  () => open.value,
  (isOpen) => {
    if (!isOpen) return
    const base = props.modelValue ? safeParse(props.modelValue) : maxDob.value
    view.value = makeViewDate((base as any).year, (base as any).month)
  }
)

watch(
  () => props.modelValue,
  () => {
    const base = props.modelValue ? safeParse(props.modelValue) : maxDob.value
    view.value = makeViewDate((base as any).year, (base as any).month)
  }
)

// ===== UI (mes/año) =====
const fromYear = 1900
const toYear = computed(() => (maxDob.value as any).year as number)

const viewYear = computed(() => Number(view.value?.year ?? (maxDob.value as any).year))
const viewMonth = computed(() => Number(view.value?.month ?? (maxDob.value as any).month))

const years = computed(() => {
  const arr: number[] = []
  for (let y = toYear.value; y >= fromYear; y--) arr.push(y)
  return arr
})

const months = computed(() => {
  const fmt = new Intl.DateTimeFormat('es-ES', { month: 'long' })
  return Array.from({ length: 12 }, (_, i) => {
    const m = i + 1
    const label = fmt.format(new Date(viewYear.value, i, 1))
    return { value: m, label: label.charAt(0).toUpperCase() + label.slice(1) }
  })
})

function setYear(y: number) {
  view.value = makeViewDate(y, viewMonth.value)
}

function setMonth(m: number) {
  view.value = makeViewDate(viewYear.value, m)
}

// ===== display =====
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
        <!-- Header Mes / Año -->
        <div class="flex items-center gap-2 p-3 pb-2">
          <select
            class="h-9 rounded-xl bg-white px-3 text-[13px] font-semibold ring-1 ring-black/10 outline-none"
            :value="viewMonth"
            @change="setMonth(Number(($event.target as HTMLSelectElement).value))"
          >
            <option v-for="m in months" :key="m.value" :value="m.value">
              {{ m.label }}
            </option>
          </select>

          <select
            class="h-9 rounded-xl bg-white px-3 text-[13px] font-semibold ring-1 ring-black/10 outline-none"
            :value="viewYear"
            @change="setYear(Number(($event.target as HTMLSelectElement).value))"
          >
            <option v-for="y in years" :key="y" :value="y">
              {{ y }}
            </option>
          </select>
        </div>

        <Calendar
          v-model="picked"
          v-model:placeholder="view"
          locale="es-ES"
          :week-starts-on="1"
          :max-value="maxDob"
        />
      </PopoverContent>
    </Popover>

    <p v-if="error" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">
      {{ error }}
    </p>
  </div>
</template>
