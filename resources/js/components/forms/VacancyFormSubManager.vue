<!-- resources/js/components/forms/VacancyFormSubManager.vue -->
<script setup lang="ts">
import { computed, reactive, ref } from 'vue'
import Container from '@/components/ui/Container.vue'
import FormAlert from '@/components/ui/FormAlert.vue'
import DatePickerShadcn from '@/components/ui/DatePickerShadcn.vue'
import SelectSucursales from '@/components/ui/SelectSucursales.vue'
import { differenceInYears, parseISO, isValid } from 'date-fns'
import axios from 'axios'

const emit = defineEmits<{ (e: 'back'): void; (e: 'close'): void }>()
const bgSrc = '/img/vacantes/bg-manager-vacancy.png'

// ========= FORM =========
const form = reactive({
  nombre: '',
  fecha_nacimiento: '',
  telefono: '',
  correo: '',
  sucursal: '',
  escolaridad: '',
  office: '',
  experiencia_anios: '',
  liderazgo: '' as '' | 'si' | 'no',

  // ===== Preguntas (MISMAS que GERENTE) =====
  p1_cartera: '' as '' | 'si' | 'no',
  p2_campo: '' as '' | 'si' | 'no',
  p3_indicadores: '' as '' | 'si' | 'no',
  p4_accion: '' as '' | 'analizo' | 'reporteo' | 'presiono',
  p5_presion: '' as '' | 'si' | 'no',
})

const errors = reactive<Record<string, string>>({})
const submitError = reactive({ message: '' })
const submitOk = reactive({ message: '' })
const sending = ref(false)

const blockedByP1 = computed(() => form.p1_cartera === 'no')

// ========= CV =========
const cvFile = ref<File | null>(null)
const cvName = ref('')
const CV_MAX_MB = 5
const CV_MAX_BYTES = CV_MAX_MB * 1024 * 1024

function clearAlerts() {
  submitError.message = ''
  submitOk.message = ''
}

function clearFieldError(key: string) {
  clearAlerts()
  if (errors[key]) delete errors[key]
}

function validateEmail(v: string) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim())
}

function normalizeTelefono(v: string) {
  return (v || '').replace(/\D/g, '').slice(0, 10)
}

// experiencia: solo dígitos (si quieres limitar a 2: .slice(0,2))
function normalizeExp(v: string) {
  return (v || '').replace(/\D/g, '')
}

function onTelefonoInput(e: Event) {
  const el = e.target as HTMLInputElement
  const digits = normalizeTelefono(el.value)
  form.telefono = digits
  el.value = digits
  clearFieldError('telefono')
}

function onExperienciaInput(e: Event) {
  const el = e.target as HTMLInputElement
  const digits = normalizeExp(el.value)
  form.experiencia_anios = digits
  el.value = digits
  clearFieldError('experiencia_anios')
}

function onCvChange(e: Event) {
  clearAlerts()
  const input = e.target as HTMLInputElement
  const file = input.files?.[0] || null

  cvFile.value = null
  cvName.value = ''
  if (errors.cv) delete errors.cv

  if (!file) return

  const name = (file.name || '').toLowerCase()
  const isPdf = file.type === 'application/pdf' || name.endsWith('.pdf')
  if (!isPdf) {
    errors.cv = 'El CV debe ser un PDF.'
    input.value = ''
    return
  }

  if (file.size > CV_MAX_BYTES) {
    errors.cv = `El CV no debe exceder ${CV_MAX_MB}MB.`
    input.value = ''
    return
  }

  cvFile.value = file
  cvName.value = file.name
  input.value = '' // permite re-subir el mismo
}

function validate() {
  clearAlerts()
  Object.keys(errors).forEach((k) => delete errors[k])

  // ===== Datos base =====
  if (!form.nombre.trim()) errors.nombre = 'Campo obligatorio'
  if (!form.fecha_nacimiento) errors.fecha_nacimiento = 'Campo obligatorio'

  // +18
  if (form.fecha_nacimiento) {
    const d = parseISO(form.fecha_nacimiento)
    if (!isValid(d)) {
      errors.fecha_nacimiento = 'Fecha inválida'
    } else if (differenceInYears(new Date(), d) < 18) {
      errors.fecha_nacimiento = 'Debes ser mayor de 18 años'
    }
  }

  form.telefono = normalizeTelefono(form.telefono)
  if (!form.telefono.trim()) errors.telefono = 'Campo obligatorio'
  if (form.telefono.trim() && form.telefono.trim().length !== 10) errors.telefono = 'Deben ser 10 dígitos (exactos)'

  if (!form.correo.trim()) errors.correo = 'Campo obligatorio'
  if (form.correo.trim() && !validateEmail(form.correo)) errors.correo = 'Correo inválido'

  if (!form.sucursal) errors.sucursal = 'Campo obligatorio'
  if (!form.escolaridad.trim()) errors.escolaridad = 'Campo obligatorio'
  if (!form.office.trim()) errors.office = 'Campo obligatorio'

  form.experiencia_anios = normalizeExp(form.experiencia_anios)
  if (!form.experiencia_anios.trim()) errors.experiencia_anios = 'Campo obligatorio'

  if (!form.liderazgo) errors.liderazgo = 'Campo obligatorio'

  // CV (si lo quieres obligatorio, descomenta)
  // if (!cvFile.value) errors.cv = 'Adjunta tu CV en PDF (obligatorio).'

  // ===== Preguntas (MISMAS que GERENTE) =====
  if (!form.p1_cartera) errors.p1_cartera = 'Campo obligatorio'
  if (form.p1_cartera === 'no') {
    submitError.message =
      'Gracias. Para este puesto necesitamos experiencia directa con cartera de crédito (colocación y cobranza).'
    return false
  }

  if (!form.p2_campo) errors.p2_campo = 'Campo obligatorio'
  if (!form.p3_indicadores) errors.p3_indicadores = 'Campo obligatorio'
  if (!form.p4_accion) errors.p4_accion = 'Campo obligatorio'
  if (!form.p5_presion) errors.p5_presion = 'Campo obligatorio'

  return Object.keys(errors).length === 0
}

async function submit() {
  if (sending.value) return

  if (!validate()) {
    if (!submitError.message) submitError.message = 'Revisar los campos marcados antes de enviar.'
    return
  }

  sending.value = true
  clearAlerts()

  try {
    const fd = new FormData()

    fd.append('nombre', form.nombre)
    fd.append('fecha_nacimiento', form.fecha_nacimiento)
    fd.append('telefono', form.telefono)
    fd.append('correo', form.correo)
    fd.append('sucursal', form.sucursal)
    fd.append('escolaridad', form.escolaridad)
    fd.append('office', form.office)
    fd.append('experiencia_anios', form.experiencia_anios)
    fd.append('liderazgo', form.liderazgo)

    fd.append('p1_cartera', form.p1_cartera)
    fd.append('p2_campo', form.p2_campo)
    fd.append('p3_indicadores', form.p3_indicadores)
    fd.append('p4_accion', form.p4_accion)
    fd.append('p5_presion', form.p5_presion)

    if (cvFile.value) fd.append('cv', cvFile.value)

    const res = await axios.post('/api/vacantes/subgerente', fd, {
      headers: { 'Content-Type': 'multipart/form-data' },
      timeout: 20000,
    })

    submitOk.message = res?.data?.message || 'Listo. La postulación se envió correctamente.'
    cvFile.value = null
    cvName.value = ''

    setTimeout(() => emit('close'), 650)
  } catch (err: any) {
    const status = err?.response?.status
    const backendMsg = err?.response?.data?.message

    const fallback =
      status === 422 ? 'Hay campos inválidos. Revisa los marcados.' :
      status ? `Error del servidor (${status}). Intenta de nuevo.` :
      'No hubo respuesta del servidor (timeout/red).'

    submitError.message = backendMsg || fallback

    // pinta errores del backend si vienen en formato Laravel {errors:{campo:[msg]}}
    const bag = err?.response?.data?.errors
    if (bag && typeof bag === 'object') {
      Object.keys(bag).forEach((k) => {
        const msg = Array.isArray(bag[k]) ? bag[k][0] : String(bag[k] ?? '')
        if (msg) errors[k] = msg
      })
    }
  } finally {
    sending.value = false
  }
}
</script>

<template>
  <div class="w-full bg-white">
    <!-- HEADER -->
    <div class="relative w-full">
      <div class="relative h-[210px] sm:h-[230px] md:h-[250px] lg:h-[270px] xl:h-[290px] 2xl:h-[310px]">
        <img
          :src="bgSrc"
          alt="Vacante Subgerente"
          class="absolute inset-0 h-full w-full object-cover object-center"
          loading="lazy"
          draggable="false"
        />
        <div class="absolute inset-0 bg-gradient-to-b from-white/5 via-white/35 to-white" />

        <div class="absolute left-3 top-3 z-20">
          <button
            type="button"
            class="group inline-flex items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs sm:text-sm font-extrabold
                   text-slate-900 ring-1 ring-black/5 shadow-sm backdrop-blur transition
                   hover:bg-white hover:shadow-[0_10px_22px_rgba(0,0,0,0.10)]
                   active:scale-[0.99] disabled:opacity-60"
            :disabled="sending"
            @click="emit('back')"
          >
            <span class="transition group-hover:-translate-x-[1px]">←</span>
            <span>Regresar</span>
          </button>
        </div>

        <div class="absolute right-3 top-3 z-20">
          <button
            type="button"
            class="grid h-9 w-9 place-items-center rounded-full bg-black/85 text-white ring-1 ring-black/5 shadow-sm backdrop-blur
                   transition hover:bg-black hover:shadow-[0_10px_22px_rgba(0,0,0,0.10)]
                   active:scale-[0.98] disabled:opacity-60"
            :disabled="sending"
            @click="emit('close')"
            aria-label="Cerrar"
          >
            ✕
          </button>
        </div>

        <div class="absolute left-4 right-4 top-[58%] -translate-y-1/2 sm:left-6 sm:right-6">
          <h2
            class="font-extrabold tracking-tight text-[#0b67a3] text-[28px] sm:text-[34px] md:text-[40px] lg:text-[46px] xl:text-[52px] 2xl:text-[56px]"
          >
            SUBGERENTE
          </h2>
          <ul class="mt-2 list-disc pl-5 text-slate-900 text-[12px] sm:text-[13px] md:text-[14px] lg:text-[15px] xl:text-[16px] space-y-1">
            <li>Soporte operativo a gerencia</li>
            <li>Supervisión de procesos</li>
            <li>Control de inventarios</li>
            <li>Atención al cliente</li>
          </ul>
        </div>
      </div>
    </div>

    <Container class="py-5 sm:py-6">
      <div class="space-y-4">
        <FormAlert v-if="submitError.message" variant="error" :message="submitError.message" />
        <FormAlert v-if="submitOk.message" variant="success" :message="submitOk.message" />

        <!-- GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
          <!-- LEFT -->
          <div class="space-y-4">
            <section class="rounded-3xl bg-slate-50 ring-1 ring-black/5 p-4 sm:p-5">
              <h3 class="text-sm sm:text-base font-extrabold text-slate-900 mb-4">Datos del candidato</h3>

              <div class="space-y-4">
                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Nombre completo</label>
                  <input
                    v-model="form.nombre"
                    class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                    @input="clearFieldError('nombre')"
                  />
                  <p v-if="errors.nombre" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.nombre }}</p>
                </div>

                <DatePickerShadcn
                  v-model="form.fecha_nacimiento"
                  label="Fecha de Nacimiento"
                  placeholder="Selecciona fecha"
                  :error="errors.fecha_nacimiento"
                  @update:modelValue="clearFieldError('fecha_nacimiento')"
                />

                <!-- Teléfono: NO LETRAS + 10 -->
                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Teléfono</label>
                  <input
                    :value="form.telefono"
                    inputmode="numeric"
                    autocomplete="tel"
                    placeholder="10 dígitos"
                    maxlength="10"
                    class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                    @input="onTelefonoInput"
                    @paste="onTelefonoInput"
                  />
                  <p class="mt-1 text-[11px] sm:text-[12px] text-slate-500">Solo números (10)</p>
                  <p v-if="errors.telefono" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.telefono }}</p>
                </div>

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Correo</label>
                  <input
                    v-model="form.correo"
                    type="email"
                    placeholder="usuario@dominio.com"
                    class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                    @input="clearFieldError('correo')"
                  />
                  <p v-if="errors.correo" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.correo }}</p>
                </div>

                <SelectSucursales
                  v-model="form.sucursal"
                  label="Sucursal"
                  placeholder="Selecciona"
                  :error="errors.sucursal"
                  @update:modelValue="clearFieldError('sucursal')"
                />
              </div>
            </section>
          </div>

          <!-- RIGHT -->
          <div class="space-y-4">
            <section class="rounded-3xl bg-slate-50 ring-1 ring-black/5 p-4 sm:p-5">
              <h3 class="text-sm sm:text-base font-extrabold text-slate-900 mb-4">Perfil</h3>

              <div class="space-y-4">
                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Escolaridad</label>
                  <input
                    v-model="form.escolaridad"
                    class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                    @input="clearFieldError('escolaridad')"
                  />
                  <p v-if="errors.escolaridad" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.escolaridad }}</p>
                </div>

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Nivel de paquetería Office</label>
                  <input
                    v-model="form.office"
                    class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                    @input="clearFieldError('office')"
                  />
                  <p v-if="errors.office" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.office }}</p>
                </div>

                <!-- Experiencia: NO LETRAS -->
                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Años de experiencia</label>
                  <input
                    :value="form.experiencia_anios"
                    inputmode="numeric"
                    placeholder="Solo números"
                    class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                    @input="onExperienciaInput"
                    @paste="onExperienciaInput"
                  />
                  <p v-if="errors.experiencia_anios" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.experiencia_anios }}</p>
                </div>

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">¿Liderazgo?</label>
                  <div class="mt-2 flex items-center gap-4 text-[13px] sm:text-[14px]">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                      <input v-model="form.liderazgo" type="radio" value="si" name="liderazgo" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('liderazgo')" />
                      <span class="font-semibold">Sí</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                      <input v-model="form.liderazgo" type="radio" value="no" name="liderazgo" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('liderazgo')" />
                      <span class="font-semibold">No</span>
                    </label>
                  </div>
                  <p v-if="errors.liderazgo" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.liderazgo }}</p>
                </div>

                <!-- CV -->
                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">CV (PDF, opcional)</label>
                  <input
                    type="file"
                    accept="application/pdf,.pdf"
                    class="mt-2 block w-full text-[13px] sm:text-[14px] file:mr-4 file:rounded-full file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-white file:font-extrabold hover:file:bg-slate-800"
                    @change="onCvChange"
                    :disabled="sending"
                  />
                  <p v-if="cvName" class="mt-2 text-[12px] text-slate-600">Archivo: <span class="font-semibold">{{ cvName }}</span></p>
                  <p v-if="errors.cv" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.cv }}</p>
                </div>
              </div>
            </section>
          </div>
        </div>

        <!-- CUESTIONARIO -->
        <section class="rounded-3xl bg-white ring-1 ring-black/5 p-4 sm:p-5">
          <h3 class="text-[14px] sm:text-[15px] font-extrabold text-slate-900">Cuestionario</h3>

          <div class="mt-4 space-y-4 text-[13px] sm:text-[14px]">
            <!-- p1 -->
            <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4">
              <div class="font-extrabold text-slate-900">
                ¿Has sido responsable directo del resultado de una cartera de crédito (colocación y cobranza)?
              </div>
              <div class="mt-2 flex items-center gap-4">
                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p1_cartera" type="radio" value="si" name="p1_cartera" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p1_cartera')" />
                  <span class="font-semibold">Sí</span>
                </label>
                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p1_cartera" type="radio" value="no" name="p1_cartera" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p1_cartera')" />
                  <span class="font-semibold">No</span>
                </label>
              </div>
              <p v-if="errors.p1_cartera" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p1_cartera }}</p>
            </div>

            <!-- p2 -->
            <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4" :class="blockedByP1 ? 'opacity-55 pointer-events-none' : ''">
              <div class="font-extrabold text-slate-900">¿Has liderado equipos comerciales de campo con metas mensuales?</div>
              <div class="mt-2 flex items-center gap-4">
                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p2_campo" type="radio" value="si" name="p2_campo" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p2_campo')" />
                  <span class="font-semibold">Sí</span>
                </label>
                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p2_campo" type="radio" value="no" name="p2_campo" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p2_campo')" />
                  <span class="font-semibold">No</span>
                </label>
              </div>
              <p v-if="errors.p2_campo" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p2_campo }}</p>
            </div>

            <!-- p3 -->
            <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4" :class="blockedByP1 ? 'opacity-55 pointer-events-none' : ''">
              <div class="font-extrabold text-slate-900">
                ¿Has trabajado con indicadores como mora, colocación, recuperación y productividad por asesor?
              </div>
              <div class="mt-2 flex items-center gap-4">
                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p3_indicadores" type="radio" value="si" name="p3_indicadores" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p3_indicadores')" />
                  <span class="font-semibold">Sí</span>
                </label>
                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p3_indicadores" type="radio" value="no" name="p3_indicadores" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p3_indicadores')" />
                  <span class="font-semibold">No</span>
                </label>
              </div>
              <p v-if="errors.p3_indicadores" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p3_indicadores }}</p>
            </div>

            <!-- p4 -->
            <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4" :class="blockedByP1 ? 'opacity-55 pointer-events-none' : ''">
              <div class="font-extrabold text-slate-900">Cuando una sucursal no cumple metas de colocación o cobranza, tú normalmente…</div>
              <div class="mt-2 space-y-2">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p4_accion" type="radio" value="analizo" name="p4_accion" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p4_accion')" />
                  <span class="font-semibold">Analizas indicadores y corriges con el equipo</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p4_accion" type="radio" value="reporteo" name="p4_accion" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p4_accion')" />
                  <span class="font-semibold">Reportas y esperas indicaciones</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p4_accion" type="radio" value="presiono" name="p4_accion" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p4_accion')" />
                  <span class="font-semibold">Presionas sin cambiar estrategia</span>
                </label>
              </div>
              <p v-if="errors.p4_accion" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p4_accion }}</p>
              <p class="mt-2 text-[11px] sm:text-[12px] text-slate-600">Buscamos decisiones con datos, no con coraje.</p>
            </div>

            <!-- p5 -->
            <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4" :class="blockedByP1 ? 'opacity-55 pointer-events-none' : ''">
              <div class="font-extrabold text-slate-900">
                Este puesto implica presión por resultados, supervisión en campo y decisiones difíciles. ¿Te sientes cómodo(a)?
              </div>
              <div class="mt-2 flex items-center gap-4">
                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p5_presion" type="radio" value="si" name="p5_presion" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p5_presion')" />
                  <span class="font-semibold">Sí</span>
                </label>
                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                  <input v-model="form.p5_presion" type="radio" value="no" name="p5_presion" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p5_presion')" />
                  <span class="font-semibold">No</span>
                </label>
              </div>
              <p v-if="errors.p5_presion" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p5_presion }}</p>
            </div>
          </div>

          <!-- CTA -->
          <div class="pt-4">
            <button
              type="button"
              :disabled="sending"
              class="group w-full rounded-full py-4 font-extrabold text-white
                     shadow-[0_18px_40px_rgba(16,185,129,0.45)]
                     transition active:scale-[0.99] disabled:opacity-60 disabled:cursor-not-allowed
                     text-[14px] sm:text-[15px] md:text-[16px] lg:text-[18px]"
              :class="sending ? 'bg-emerald-500/70' : 'bg-emerald-500 hover:bg-emerald-600 hover:shadow-[0_22px_52px_rgba(16,185,129,0.55)]'"
              @click="submit"
            >
              <span class="inline-flex items-center justify-center gap-2">
                {{ sending ? 'Enviando...' : 'Postularse' }}
                <span class="transition group-hover:translate-x-[2px]">→</span>
              </span>
            </button>
          </div>
        </section>
      </div>
    </Container>
  </div>
</template>
