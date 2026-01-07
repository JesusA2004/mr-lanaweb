<script setup lang="ts">
    import { computed, reactive, ref } from 'vue'
    import type { Vacancy } from '@/data/vacantes'
    import VacancyCard from './VacancyCard.vue'
    
    const props = defineProps<{ vacancies: Vacancy[] }>()
    const roles = computed(() => Array.from(new Set(props.vacancies.map(v => v.role))))
    
    const activeRole = ref(roles.value[0] ?? '')
    const open = ref(false)
    const selected = ref<Vacancy | null>(null)
    
    const applyForm = reactive({
      nombre: '',
      telefono: '',
      correo: '',
      acepta: false,
    })
    
    const errors = reactive<Record<string, string>>({})
    
    function openApply(v: Vacancy) {
      selected.value = v
      open.value = true
    }
    
    function close() {
      open.value = false
      selected.value = null
      Object.keys(errors).forEach((k) => delete errors[k])
    }
    
    function emailOk(v: string) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim())
    }
    
    function validate() {
      Object.keys(errors).forEach((k) => delete errors[k])
      if (!applyForm.nombre.trim()) errors.nombre = 'Nombre requerido.'
      if (!applyForm.telefono.replace(/\D/g, '') || applyForm.telefono.replace(/\D/g, '').length < 10) errors.telefono = 'Teléfono inválido.'
      if (!emailOk(applyForm.correo)) errors.correo = 'Correo inválido.'
      if (!applyForm.acepta) errors.acepta = 'Debes aceptar aviso y términos.'
      return Object.keys(errors).length === 0
    }
    
    function submit() {
      if (!validate()) return
      close()
    }
    </script>
    
    <template>
      <section class="py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="rounded-3xl border border-slate-200 bg-white p-8 md:p-10">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
              <div>
                <p class="inline-flex rounded-full bg-[#C2F6EC] px-4 py-1 text-sm font-semibold text-[#106A59]">
                  Bolsa de trabajo
                </p>
                <h2 class="mt-4 text-2xl md:text-3xl font-bold text-slate-900">Conoce nuestras vacantes</h2>
                <p class="mt-2 text-slate-600">Postúlate y crece con el equipo.</p>
              </div>
    
              <div class="flex flex-wrap gap-2">
                <button
                  v-for="r in roles"
                  :key="r"
                  type="button"
                  class="rounded-2xl border px-4 py-2 text-sm font-semibold transition"
                  :class="activeRole === r ? 'border-[#1DC1A2] bg-[#C2F6EC]/50 text-[#106A59]' : 'border-slate-200 bg-white text-slate-800 hover:bg-slate-50'"
                  @click="activeRole = r"
                >
                  {{ r }}
                </button>
              </div>
            </div>
    
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
              <VacancyCard
                v-for="v in props.vacancies.filter(x => x.role === activeRole)"
                :key="v.id"
                :vacancy="v"
                @apply="openApply"
              />
            </div>
          </div>
        </div>
    
        <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <div class="absolute inset-0 bg-black/50" @click="close"></div>
          <div class="relative w-full max-w-lg rounded-3xl bg-white p-6 shadow-xl">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-xs font-semibold text-[#106A59]">Postulación</p>
                <p class="mt-1 text-lg font-bold text-slate-900">{{ selected?.role }}</p>
              </div>
              <button type="button" class="rounded-xl border px-3 py-2 hover:bg-slate-50" @click="close">✕</button>
            </div>
    
            <form class="mt-6 grid gap-4" @submit.prevent="submit">
              <div class="grid gap-2">
                <label class="text-sm font-semibold text-slate-900">Nombre</label>
                <input v-model="applyForm.nombre" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40" />
                <p v-if="errors.nombre" class="text-xs text-rose-600">{{ errors.nombre }}</p>
              </div>
    
              <div class="grid gap-2 md:grid-cols-2 md:gap-4">
                <div class="grid gap-2">
                  <label class="text-sm font-semibold text-slate-900">Teléfono</label>
                  <input v-model="applyForm.telefono" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40" />
                  <p v-if="errors.telefono" class="text-xs text-rose-600">{{ errors.telefono }}</p>
                </div>
    
                <div class="grid gap-2">
                  <label class="text-sm font-semibold text-slate-900">Correo</label>
                  <input v-model="applyForm.correo" type="email" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1DC1A2]/40" />
                  <p v-if="errors.correo" class="text-xs text-rose-600">{{ errors.correo }}</p>
                </div>
              </div>
    
              <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4">
                <input v-model="applyForm.acepta" type="checkbox" class="mt-1 h-4 w-4" />
                <span class="text-sm text-slate-700">
                  Acepto aviso de privacidad y términos y condiciones.
                </span>
              </label>
              <p v-if="errors.acepta" class="text-xs text-rose-600">{{ errors.acepta }}</p>
    
              <button type="submit" class="rounded-2xl bg-[#1DC1A2] px-6 py-4 text-base font-semibold text-white hover:bg-[#106A59] transition">
                Enviar postulación
              </button>
            </form>
          </div>
        </div>
      </section>
    </template>
    