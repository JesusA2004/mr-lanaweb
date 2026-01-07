<script setup lang="ts">
    import { computed, reactive } from 'vue'
    import type { Branch } from '@/data/sucursales'
    import BranchSelect from './BranchSelect.vue'
    
    export type LoanRequestPayload = {
      nombres: string
      apellidos: string
      correo: string
      telefono: string
      direccion: string
      sucursalId: string
      tieneNegocioFisico?: boolean | null
      aceptaLegales: boolean
      frecuencia?: 'diario' | 'semanal'
    }
    
    const props = defineProps<{
      branches: Branch[]
      showBusinessToggle?: boolean
      frequency?: 'diario' | 'semanal'
      submitLabel?: string
    }>()
    
    const emit = defineEmits<{
      (e: 'submit', payload: LoanRequestPayload): void
    }>()
    
    const form = reactive<LoanRequestPayload>({
      nombres: '',
      apellidos: '',
      correo: '',
      telefono: '',
      direccion: '',
      sucursalId: '',
      tieneNegocioFisico: null,
      aceptaLegales: false,
      frecuencia: props.frequency,
    })
    
    const errors = reactive<Record<string, string>>({})
    
    const emailOk = (v: string) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim())
    const phoneOk = (v: string) => v.replace(/\D/g, '').length >= 10
    
    const canSubmit = computed(() => {
      if (!form.nombres.trim()) return false
      if (!form.apellidos.trim()) return false
      if (!emailOk(form.correo)) return false
      if (!phoneOk(form.telefono)) return false
      if (!form.direccion.trim()) return false
      if (!form.sucursalId) return false
      if (props.showBusinessToggle && form.tieneNegocioFisico === null) return false
      if (!form.aceptaLegales) return false
      return true
    })
    
    function validate() {
      Object.keys(errors).forEach((k) => delete errors[k])
    
      if (!form.nombres.trim()) errors.nombres = 'Ingresa nombre(s).'
      if (!form.apellidos.trim()) errors.apellidos = 'Ingresa apellidos.'
      if (!emailOk(form.correo)) errors.correo = 'Correo inválido.'
      if (!phoneOk(form.telefono)) errors.telefono = 'Teléfono inválido (mínimo 10 dígitos).'
      if (!form.direccion.trim()) errors.direccion = 'Ingresa dirección.'
      if (!form.sucursalId) errors.sucursalId = 'Selecciona sucursal.'
      if (props.showBusinessToggle && form.tieneNegocioFisico === null) errors.tieneNegocioFisico = 'Selecciona una opción.'
      if (!form.aceptaLegales) errors.aceptaLegales = 'Debes aceptar aviso y términos.'
      return Object.keys(errors).length === 0
    }
    
    function onSubmit() {
      if (!validate()) return
      emit('submit', { ...form, frecuencia: props.frequency ?? form.frecuencia })
    }
    </script>
    
    <template>
      <form class="grid gap-4" @submit.prevent="onSubmit">
        <div class="grid gap-2">
          <label class="text-sm font-semibold text-slate-900">Nombre(s)</label>
          <input
            v-model="form.nombres"
            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40"
            placeholder="Ej. Juan Carlos"
          />
          <p v-if="errors.nombres" class="text-xs text-rose-600">{{ errors.nombres }}</p>
        </div>
    
        <div class="grid gap-2">
          <label class="text-sm font-semibold text-slate-900">Apellidos</label>
          <input
            v-model="form.apellidos"
            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40"
            placeholder="Ej. Pérez López"
          />
          <p v-if="errors.apellidos" class="text-xs text-rose-600">{{ errors.apellidos }}</p>
        </div>
    
        <div class="grid gap-2 md:grid-cols-2 md:gap-4">
          <div class="grid gap-2">
            <label class="text-sm font-semibold text-slate-900">Correo</label>
            <input
              v-model="form.correo"
              type="email"
              class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40"
              placeholder="correo@ejemplo.com"
            />
            <p v-if="errors.correo" class="text-xs text-rose-600">{{ errors.correo }}</p>
          </div>
    
          <div class="grid gap-2">
            <label class="text-sm font-semibold text-slate-900">Teléfono</label>
            <input
              v-model="form.telefono"
              inputmode="tel"
              class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40"
              placeholder="10 dígitos"
            />
            <p v-if="errors.telefono" class="text-xs text-rose-600">{{ errors.telefono }}</p>
          </div>
        </div>
    
        <div class="grid gap-2">
          <label class="text-sm font-semibold text-slate-900">Dirección</label>
          <input
            v-model="form.direccion"
            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40"
            placeholder="Calle, número, colonia"
          />
          <p v-if="errors.direccion" class="text-xs text-rose-600">{{ errors.direccion }}</p>
        </div>
    
        <div class="grid gap-2">
          <label class="text-sm font-semibold text-slate-900">Sucursal</label>
          <BranchSelect v-model="form.sucursalId" :branches="branches" />
          <p v-if="errors.sucursalId" class="text-xs text-rose-600">{{ errors.sucursalId }}</p>
        </div>
    
        <div v-if="showBusinessToggle" class="grid gap-2">
          <label class="text-sm font-semibold text-slate-900">¿Tienes negocio físico?</label>
          <div class="grid grid-cols-2 gap-3">
            <button
              type="button"
              class="rounded-2xl border px-4 py-3 text-sm font-semibold transition"
              :class="form.tieneNegocioFisico === true ? 'border-[#1DC1A2] bg-[#C2F6EC]/50 text-[#106A59]' : 'border-slate-200 bg-white text-slate-800 hover:bg-slate-50'"
              @click="form.tieneNegocioFisico = true"
            >
              Sí
            </button>
            <button
              type="button"
              class="rounded-2xl border px-4 py-3 text-sm font-semibold transition"
              :class="form.tieneNegocioFisico === false ? 'border-[#1DC1A2] bg-[#C2F6EC]/50 text-[#106A59]' : 'border-slate-200 bg-white text-slate-800 hover:bg-slate-50'"
              @click="form.tieneNegocioFisico = false"
            >
              No
            </button>
          </div>
          <p v-if="errors.tieneNegocioFisico" class="text-xs text-rose-600">{{ errors.tieneNegocioFisico }}</p>
        </div>
    
        <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4">
          <input v-model="form.aceptaLegales" type="checkbox" class="mt-1 h-4 w-4" />
          <span class="text-sm text-slate-700">
            Acepto aviso de privacidad y términos y condiciones.
            <span class="text-slate-500">(Obligatorio)</span>
          </span>
        </label>
        <p v-if="errors.aceptaLegales" class="text-xs text-rose-600">{{ errors.aceptaLegales }}</p>
    
        <button
          type="submit"
          class="rounded-2xl bg-[#1DC1A2] px-6 py-4 text-base font-semibold text-white hover:bg-[#106A59] disabled:opacity-60 disabled:cursor-not-allowed transition"
          :disabled="!canSubmit"
        >
          {{ submitLabel ?? 'Enviar solicitud' }}
        </button>
      </form>
    </template>
    