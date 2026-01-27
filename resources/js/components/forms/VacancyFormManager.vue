<script setup lang="ts">
import { computed, reactive, ref } from 'vue'
import Container from '@/components/ui/Container.vue'
import FormAlert from '@/components/ui/FormAlert.vue'
import DatePickerShadcn from '@/components/ui/DatePickerShadcn.vue'
import NumericInput from '@/components/ui/NumericInput.vue'
import SelectSucursales from '@/components/ui/SelectSucursales.vue'
import { differenceInYears, parseISO, isValid } from 'date-fns'
import axios from 'axios'

const emit = defineEmits<{ (e: 'back'): void; (e: 'close'): void }>()

const bgSrc = '/img/vacantes/bg-manager-vacancy.png'

const form = reactive({
  nombre: '',
  fecha_nacimiento: '',
  telefono: '',
  correo: '',
  sucursal: '',
  escolaridad: '',
  office: '',
  experiencia_anios: '',
  liderazgo: '',

  // ===== Preguntas filtro =====
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

// ===== CV (PDF) =====
const cvFile = ref<File | null>(null)
const cvDragOver = ref(false)
const cvInputRef = ref<HTMLInputElement | null>(null)
const CV_MAX_MB = 5
const CV_MAX_BYTES = CV_MAX_MB * 1024 * 1024

function clearAlerts() {
  submitError.message = ''
  submitOk.message = ''
}

function validateEmail(v: string) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim())
}

function normalizeTelefono(v: string) {
  return (v || '').replace(/\D/g, '').slice(0, 10)
}

const blockedByP1 = computed(() => form.p1_cartera === 'no')

function clearFieldError(key: string) {
  clearAlerts()
  if (errors[key]) delete errors[key]
}

function formatBytes(bytes: number) {
  const mb = bytes / 1024 / 1024
  return `${mb.toFixed(2)} MB`
}

function pickCv() {
  cvInputRef.value?.click()
}

function resetCv() {
  cvFile.value = null
  clearFieldError('cv')
}

function setCv(file: File | null) {
  clearAlerts()
  if (!file) return

  // tipo y extensión
  const name = (file.name || '').toLowerCase()
  const isPdf = file.type === 'application/pdf' || name.endsWith('.pdf')
  if (!isPdf) {
    errors.cv = 'Solo se permite PDF.'
    cvFile.value = null
    return
  }

  if (file.size > CV_MAX_BYTES) {
    errors.cv = `El PDF excede ${CV_MAX_MB}MB. Tamaño actual: ${formatBytes(file.size)}`
    cvFile.value = null
    return
  }

  cvFile.value = file
  if (errors.cv) delete errors.cv
}

function onCvInputChange(e: Event) {
  const input = e.target as HTMLInputElement
  const file = input.files?.[0] ?? null
  setCv(file)
  // importante: permite re-seleccionar el mismo archivo
  if (input) input.value = ''
}

function onDropCv(e: DragEvent) {
  e.preventDefault()
  cvDragOver.value = false
  const file = e.dataTransfer?.files?.[0] ?? null
  setCv(file)
}

function validate() {
  clearAlerts()
  Object.keys(errors).forEach((k) => delete errors[k])

  // ===== Datos base =====
  if (!form.nombre.trim()) errors.nombre = 'Campo obligatorio'
  if (!form.fecha_nacimiento) errors.fecha_nacimiento = 'Campo obligatorio'

  // ===== Regla: mayor o igual a 18 =====
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
  if (form.telefono.trim() && form.telefono.trim().length !== 10) errors.telefono = 'Deben ser 10 dígitos'

  if (!form.correo.trim()) errors.correo = 'Campo obligatorio'
  if (form.correo.trim() && !validateEmail(form.correo)) errors.correo = 'Correo inválido'

  if (!form.sucursal) errors.sucursal = 'Campo obligatorio'
  if (!form.escolaridad.trim()) errors.escolaridad = 'Campo obligatorio'
  if (!form.office.trim()) errors.office = 'Campo obligatorio'
  if (!form.experiencia_anios.trim()) errors.experiencia_anios = 'Campo obligatorio'
  if (!form.liderazgo) errors.liderazgo = 'Campo obligatorio'

  // ===== CV (para gerente yo lo haría obligatorio) =====
  if (!cvFile.value) errors.cv = 'Adjunta tu CV en PDF (obligatorio).'

  // ===== Preguntas =====
  if (!form.p1_cartera) errors.p1_cartera = 'Selecciona una opción.'
  if (form.p1_cartera === 'no') {
    submitError.message =
      'Gracias. Para este puesto necesitamos experiencia directa con cartera de crédito (colocación y cobranza).'
    return false
  }

  if (!form.p2_campo) errors.p2_campo = 'Selecciona una opción.'
  if (!form.p3_indicadores) errors.p3_indicadores = 'Selecciona una opción.'
  if (!form.p4_accion) errors.p4_accion = 'Selecciona una opción.'
  if (!form.p5_presion) errors.p5_presion = 'Selecciona una opción.'

  return Object.keys(errors).length === 0
}

/**
 * AQUÍ está el botón real:
 * - arma FormData
 * - pega al controller (POST /vacantes/gerente)
 * - el backend manda correo a reclutamiento@mr-lana.com con CV adjunto
 */
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
    fd.append('telefono', normalizeTelefono(form.telefono))
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

    const res = await axios.post('/api/vacantes/gerente', fd, {
      headers: { 'Content-Type': 'multipart/form-data' },
      timeout: 20000, // <- clave: si el backend no responde, aquí truena y te muestra error
    })

    submitOk.message = res?.data?.message || 'Listo. La postulación se envió correctamente.'
    resetCv()

    // Cierra el modal con éxito (si quieres)
    setTimeout(() => emit('close'), 650)

  } catch (err: any) {
    // muestra algo SIEMPRE
    const status = err?.response?.status
    const backendMsg = err?.response?.data?.message
    const fallback =
      status === 419 ? 'Sesión/CSRF inválido (usa /api para evitarlo).' :
      status === 422 ? 'Hay campos inválidos. Revisa los marcados.' :
      status ? `Error del servidor (${status}). Intenta de nuevo.` :
      'No hubo respuesta del servidor (timeout/red).'

    submitError.message = backendMsg || fallback
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
          alt="Vacante Gerente"
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
            GERENTE
          </h2>
          <ul class="mt-2 list-disc pl-5 text-slate-900 text-[12px] sm:text-[13px] md:text-[14px] lg:text-[15px] xl:text-[16px] space-y-1">
            <li>Gestión de sucursal y metas</li>
            <li>Liderazgo de equipo</li>
            <li>Seguimiento de indicadores</li>
            <li>Atención y resolución operativa</li>
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
            <!-- 1) Datos -->
            <section class="rounded-3xl bg-slate-50 ring-1 ring-black/5 p-4 sm:p-5">
              <div class="flex items-center gap-2 mb-4">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 21a8 8 0 10-16 0M12 11a4 4 0 100-8 4 4 0 000 8z" />
                </svg>
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Datos del candidato</h3>
              </div>

              <div class="space-y-4">
                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Nombre completo</label>
                  <input
                    v-model="form.nombre"
                    class="mt-1 w-full rounded-2xl bg-white px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
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

                <NumericInput
                  v-model="form.telefono"
                  label="Teléfono"
                  placeholder="10 dígitos"
                  :max-length="10"
                  :error="errors.telefono"
                  @update:modelValue="clearFieldError('telefono')"
                />

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Correo</label>
                  <input
                    placeholder="usuario@dominio.com"
                    v-model="form.correo"
                    type="email"
                    class="mt-1 w-full rounded-2xl bg-white px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
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

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Escolaridad</label>
                  <input
                    v-model="form.escolaridad"
                    class="mt-1 w-full rounded-2xl bg-white px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                    @input="clearFieldError('escolaridad')"
                  />
                  <p v-if="errors.escolaridad" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.escolaridad }}</p>
                </div>

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Nivel de paquetería Office</label>
                  <input
                    v-model="form.office"
                    class="mt-1 w-full rounded-2xl bg-white px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                    @input="clearFieldError('office')"
                  />
                  <p v-if="errors.office" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.office }}</p>
                </div>

                <NumericInput
                  v-model="form.experiencia_anios"
                  label="Años de experiencia"
                  placeholder="Solo números"
                  :error="errors.experiencia_anios"
                  @update:modelValue="clearFieldError('experiencia_anios')"
                />

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">¿Experiencia liderando equipo?</label>
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
              </div>
            </section>

            <!-- 2) CV -->
            <section class="rounded-3xl bg-white ring-1 ring-black/5 p-4 sm:p-5">
              <div class="flex items-center justify-between gap-3 mb-3">
                <div class="flex items-center gap-2">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6" />
                  </svg>
                  <h3 class="text-sm sm:text-base font-extrabold text-slate-900">CV (PDF)</h3>
                </div>

                <button
                  type="button"
                  class="rounded-full px-3 py-2 text-xs sm:text-sm font-extrabold
                         bg-slate-900 text-white shadow-sm transition hover:bg-slate-800 disabled:opacity-60"
                  :disabled="sending"
                  @click="pickCv"
                >
                  Elegir archivo
                </button>

                <input
                  ref="cvInputRef"
                  type="file"
                  accept="application/pdf,.pdf"
                  class="hidden"
                  @change="onCvInputChange"
                />
              </div>

              <div
                class="rounded-2xl border-2 border-dashed p-4 sm:p-5 transition"
                :class="[
                  cvDragOver ? 'border-emerald-500 bg-emerald-50/40' : 'border-slate-200 bg-slate-50',
                  sending ? 'opacity-60 pointer-events-none' : '',
                ]"
                @dragenter.prevent="cvDragOver = true"
                @dragover.prevent="cvDragOver = true"
                @dragleave.prevent="cvDragOver = false"
                @drop="onDropCv"
              >
                <div class="flex items-start gap-3">
                  <div class="mt-0.5 grid h-10 w-10 place-items-center rounded-2xl bg-white ring-1 ring-black/5">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 16v-8m0 0l-3 3m3-3l3 3M20 16.5a4.5 4.5 0 00-3.6-4.4A5 5 0 006.5 9.5
                           4 4 0 006 17h14z" />
                    </svg>
                  </div>

                  <div class="flex-1">
                    <p class="font-extrabold text-slate-900 text-[13px] sm:text-[14px]">
                      Suelta tu PDF aquí o usa “Elegir archivo”.
                    </p>
                    <p class="mt-1 text-[11px] sm:text-[12px] text-slate-600">
                      Solo PDF. Máximo {{ CV_MAX_MB }}MB. Se usa únicamente para enviarlo a reclutamiento.
                    </p>

                    <div v-if="cvFile" class="mt-3 flex items-center justify-between gap-3 rounded-2xl bg-white ring-1 ring-black/5 px-3 py-2">
                      <div class="min-w-0">
                        <p class="truncate text-[12px] sm:text-[13px] font-extrabold text-slate-900">
                          {{ cvFile.name }}
                        </p>
                        <p class="text-[11px] sm:text-[12px] text-slate-600">
                          {{ formatBytes(cvFile.size) }}
                        </p>
                      </div>

                      <button
                        type="button"
                        class="rounded-full px-3 py-1.5 text-[12px] font-extrabold bg-rose-600 text-white hover:bg-rose-700 transition"
                        @click="resetCv"
                      >
                        Quitar
                      </button>
                    </div>

                    <p v-if="errors.cv" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">
                      {{ errors.cv }}
                    </p>
                  </div>
                </div>
              </div>
            </section>
          </div>

          <!-- RIGHT -->
          <section class="rounded-3xl bg-white ring-1 ring-black/5 p-4 sm:p-5">
            <div class="flex items-center gap-2 mb-4">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3L22 4M2 20h20M2 4h11" />
              </svg>
              <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Cuestionario</h3>
            </div>

            <div class="space-y-4">
              <!-- P1 -->
              <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4 transition hover:shadow-sm">
                <p class="font-extrabold text-slate-900 text-[13px] sm:text-[14px]">
                  ¿Has sido responsable directo del resultado de una cartera de crédito (colocación y cobranza)?
                </p>
                <div class="mt-3 flex items-center gap-5 text-[13px] sm:text-[14px]">
                  <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input v-model="form.p1_cartera" type="radio" value="si" name="p1" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p1_cartera')" />
                    <span class="font-semibold">Sí</span>
                  </label>
                  <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input v-model="form.p1_cartera" type="radio" value="no" name="p1" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p1_cartera')" />
                    <span class="font-semibold">No</span>
                  </label>
                </div>
                <p v-if="errors.p1_cartera" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p1_cartera }}</p>
              </div>

              <!-- P2 -->
              <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4 transition hover:shadow-sm" :class="blockedByP1 ? 'opacity-55 pointer-events-none' : ''">
                <p class="font-extrabold text-slate-900 text-[13px] sm:text-[14px]">
                  ¿Has liderado equipos comerciales de campo con metas mensuales?
                </p>
                <div class="mt-3 flex items-center gap-5 text-[13px] sm:text-[14px]">
                  <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input v-model="form.p2_campo" type="radio" value="si" name="p2" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p2_campo')" />
                    <span class="font-semibold">Sí</span>
                  </label>
                  <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input v-model="form.p2_campo" type="radio" value="no" name="p2" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p2_campo')" />
                    <span class="font-semibold">No</span>
                  </label>
                </div>
                <p v-if="errors.p2_campo" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p2_campo }}</p>
              </div>

              <!-- P3 -->
              <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4 transition hover:shadow-sm" :class="blockedByP1 ? 'opacity-55 pointer-events-none' : ''">
                <p class="font-extrabold text-slate-900 text-[13px] sm:text-[14px]">
                  ¿Has trabajado con indicadores como mora, colocación, recuperación y productividad por asesor?
                </p>
                <div class="mt-3 flex items-center gap-5 text-[13px] sm:text-[14px]">
                  <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input v-model="form.p3_indicadores" type="radio" value="si" name="p3" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p3_indicadores')" />
                    <span class="font-semibold">Sí</span>
                  </label>
                  <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input v-model="form.p3_indicadores" type="radio" value="no" name="p3" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p3_indicadores')" />
                    <span class="font-semibold">No</span>
                  </label>
                </div>
                <p v-if="errors.p3_indicadores" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p3_indicadores }}</p>
              </div>

              <!-- P4 -->
              <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4 transition hover:shadow-sm" :class="blockedByP1 ? 'opacity-55 pointer-events-none' : ''">
                <p class="font-extrabold text-slate-900 text-[13px] sm:text-[14px]">
                  Cuando una sucursal no cumple metas de colocación o cobranza, tú normalmente…
                </p>
                <div class="mt-3 space-y-2 text-[13px] sm:text-[14px]">
                  <label class="flex items-start gap-2 cursor-pointer">
                    <input v-model="form.p4_accion" type="radio" value="analizo" name="p4" class="mt-1 h-4 w-4 accent-emerald-500" @change="clearFieldError('p4_accion')" />
                    <span class="font-semibold">Analizas indicadores y corriges con el equipo</span>
                  </label>
                  <label class="flex items-start gap-2 cursor-pointer">
                    <input v-model="form.p4_accion" type="radio" value="reporteo" name="p4" class="mt-1 h-4 w-4 accent-emerald-500" @change="clearFieldError('p4_accion')" />
                    <span class="font-semibold">Reportas y esperas indicaciones</span>
                  </label>
                  <label class="flex items-start gap-2 cursor-pointer">
                    <input v-model="form.p4_accion" type="radio" value="presiono" name="p4" class="mt-1 h-4 w-4 accent-emerald-500" @change="clearFieldError('p4_accion')" />
                    <span class="font-semibold">Presionas sin cambiar estrategia</span>
                  </label>
                </div>

                <p v-if="errors.p4_accion" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p4_accion }}</p>
                <p class="mt-2 text-[11px] sm:text-[12px] text-slate-600">Buscamos decisiones con datos, no con coraje.</p>
              </div>

              <!-- P5 -->
              <div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4 transition hover:shadow-sm" :class="blockedByP1 ? 'opacity-55 pointer-events-none' : ''">
                <p class="font-extrabold text-slate-900 text-[13px] sm:text-[14px]">
                  Este puesto implica presión por resultados, supervisión en campo y decisiones difíciles. ¿Te sientes cómodo(a)?
                </p>
                <div class="mt-3 flex items-center gap-5 text-[13px] sm:text-[14px]">
                  <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input v-model="form.p5_presion" type="radio" value="si" name="p5" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p5_presion')" />
                    <span class="font-semibold">Sí</span>
                  </label>
                  <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input v-model="form.p5_presion" type="radio" value="no" name="p5" class="h-4 w-4 accent-emerald-500" @change="clearFieldError('p5_presion')" />
                    <span class="font-semibold">No</span>
                  </label>
                </div>
                <p v-if="errors.p5_presion" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p5_presion }}</p>
              </div>

              <!-- CTA: ESTE es el botón que dispara submit() -->
              <div class="pt-2">
                <button
                  type="button"
                  class="group w-full rounded-full py-4 font-extrabold text-white
                         shadow-[0_18px_40px_rgba(16,185,129,0.45)]
                         transition active:scale-[0.99] disabled:opacity-60 disabled:cursor-not-allowed
                         text-[14px] sm:text-[15px] md:text-[16px] lg:text-[18px]"
                  :class="sending ? 'bg-emerald-500/70' : 'bg-emerald-500 hover:bg-emerald-600 hover:shadow-[0_22px_52px_rgba(16,185,129,0.55)]'"
                  :disabled="sending"
                  @click="submit"
                >
                  <span v-if="!sending" class="inline-flex items-center justify-center gap-2">
                    Postularse <span class="transition group-hover:translate-x-[2px]">→</span>
                  </span>

                  <span v-else class="inline-flex items-center justify-center gap-2">
                    <span>Enviando</span>
                    <span class="inline-flex w-8 justify-start">
                      <span class="dot dot-1">.</span>
                      <span class="dot dot-2">.</span>
                      <span class="dot dot-3">.</span>
                    </span>
                  </span>
                </button>

                <p v-if="sending" class="mt-2 text-center text-[11px] sm:text-[12px] text-slate-600">
                  Estamos procesando tu postulación. No cierres esta ventana.
                </p>
              </div>
            </div>
          </section>
        </div>
      </div>
    </Container>
  </div>
</template>

<style scoped>
.dot { display:inline-block; animation:bounce 1s infinite ease-in-out; }
.dot-2 { animation-delay:.15s; }
.dot-3 { animation-delay:.3s; }
@keyframes bounce {
  0%,80%,100% { transform:translateY(0); opacity:.25; }
  40% { transform:translateY(-3px); opacity:1; }
}
</style>
