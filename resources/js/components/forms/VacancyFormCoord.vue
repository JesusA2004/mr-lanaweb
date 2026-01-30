<!-- resources/js/components/vacancies/VacancyFormCoordinator.vue -->
<script setup lang="ts">
import { computed, ref } from 'vue'
import Container from '@/components/ui/Container.vue'
import FormAlert from '@/components/ui/FormAlert.vue'
import DatePickerShadcn from '@/components/ui/DatePickerShadcn.vue'
import SelectSucursales from '@/components/ui/SelectSucursales.vue'
import { swalNotify } from '@/lib/swal'
import { useVacancyCoordinator } from '@/composables/useVacancyCoordinator'

const emit = defineEmits<{ (e: 'back'): void; (e: 'close'): void }>()
const bgSrc = '/img/vacantes/bg-coord-vacancy.jpg'

const {
  form,
  errors,
  p4Human,
  submitError,
  submitOk,
  cvFile,
  cvName,
  onCvChange,
  onTelefonoInput,
  clearFieldError,
  clearAlerts,
  sending,
  submit,
} = useVacancyCoordinator('/api/vacantes/coordinadora')

const cvInput = ref<HTMLInputElement | null>(null)
const hasCv = computed(() => !!cvName.value)
const canSend = computed(() => !sending.value)

function handleCvInput(e: Event) {
  const input = e.target as HTMLInputElement
  const file = input.files?.[0] || null
  onCvChange(file)
  input.value = ''
}

function removeCv() {
  onCvChange(null)
  if (cvInput.value) cvInput.value.value = ''
}

async function handleSubmit() {
  const result = await submit()
  if (result.ok) {
    emit('close')
    clearAlerts()
    await swalNotify('success', result.message, 'Postulación enviada')
    return
  }
  await swalNotify('error', result.message, 'No se pudo enviar')
}
</script>

<template>
  <div class="w-full bg-white">
    <!-- HERO -->
    <div class="relative w-full">
      <div class="relative h-[210px] sm:h-[230px] md:h-[250px] lg:h-[270px] xl:h-[290px] 2xl:h-[310px]">
        <img :src="bgSrc" alt="Vacante Coordinadora" class="absolute inset-0 h-full w-full object-cover object-center" loading="lazy" draggable="false" />
        <div class="absolute inset-0 bg-gradient-to-b from-white/5 via-white/35 to-white" />
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(16,185,129,0.20),transparent_55%)]" />

        <div class="absolute left-3 top-3 z-20">
          <button
            type="button"
            class="group inline-flex items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs sm:text-sm font-extrabold text-slate-900
                   ring-1 ring-black/5 shadow-sm backdrop-blur transition
                   hover:bg-white hover:shadow-[0_10px_22px_rgba(0,0,0,0.10)] active:scale-[0.99] disabled:opacity-60"
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
            class="grid h-9 w-9 place-items-center rounded-full bg-black/85 text-white
                   ring-1 ring-black/5 shadow-sm backdrop-blur transition
                   hover:bg-white hover:text-slate-900 hover:shadow-[0_10px_22px_rgba(0,0,0,0.10)] active:scale-[0.98] disabled:opacity-60"
            :disabled="sending"
            @click="emit('close')"
            aria-label="Cerrar"
            title="Cerrar"
          >
            ✕
          </button>
        </div>

        <div class="absolute left-4 right-4 top-[58%] -translate-y-1/2 sm:left-6 sm:right-6">
          <h2
            class="font-extrabold tracking-tight text-[#0b67a3]
                   text-[28px] sm:text-[34px] md:text-[40px] lg:text-[46px] xl:text-[52px] 2xl:text-[56px]"
          >
            COORDINADORA
          </h2>

          <ul
            class="mt-2 list-disc pl-5 text-slate-900
                   text-[12px] sm:text-[13px] md:text-[14px] lg:text-[15px] xl:text-[16px]
                   space-y-1"
          >
            <li>Cuadre y arqueo de caja</li>
            <li>Entrega de fondos</li>
            <li>Control de expedientes</li>
            <li>Comprobación de gastos</li>
          </ul>
        </div>
      </div>
    </div>

    <Container class="py-5 sm:py-6">
      <div class="space-y-4">
        <FormAlert v-if="submitError" variant="error" :message="submitError" />
        <FormAlert v-if="submitOk" variant="success" :message="submitOk" />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
          <!-- DATOS -->
          <div class="rounded-3xl border border-black/5 bg-white/80 p-4 sm:p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3">
              <div class="text-[13px] sm:text-[14px] font-extrabold text-slate-900">Datos del candidato</div>
              <div class="text-[11px] sm:text-[12px] font-semibold text-slate-500">Vacantes · Coordinadora</div>
            </div>

            <div class="mt-4 space-y-4">
              <div>
                <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Nombre completo</label>
                <input
                  v-model="form.nombre"
                  class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 placeholder:text-slate-500
                         ring-1 ring-black/5 outline-none transition
                         hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60
                         text-[13px] sm:text-[14px] md:text-[15px]"
                  placeholder="Escribe aquí"
                  @input="clearAlerts(); clearFieldError('nombre')"
                />
                <p v-if="errors.nombre" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.nombre }}</p>
              </div>

              <DatePickerShadcn
                v-model="form.fecha_nacimiento"
                label="Fecha de Nacimiento"
                placeholder="Selecciona fecha"
                :error="errors.fecha_nacimiento"
                @update:modelValue="clearAlerts(); clearFieldError('fecha_nacimiento')"
              />

              <!-- Teléfono (hard-stop 10 dígitos) -->
              <div>
                <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Teléfono</label>
                <input
                  :value="form.telefono"
                  inputmode="numeric"
                  autocomplete="tel"
                  maxlength="10"
                  placeholder="10 dígitos"
                  class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 placeholder:text-slate-500
                         ring-1 ring-black/5 outline-none transition
                         hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60
                         text-[13px] sm:text-[14px] md:text-[15px]"
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
                  class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 placeholder:text-slate-500
                         ring-1 ring-black/5 outline-none transition
                         hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60
                         text-[13px] sm:text-[14px] md:text-[15px]"
                  placeholder="correo@dominio.com"
                  @input="clearAlerts(); clearFieldError('correo')"
                />
                <p v-if="errors.correo" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.correo }}</p>
              </div>

              <SelectSucursales
                v-model="form.sucursal"
                label="Sucursal"
                placeholder="Selecciona"
                :error="errors.sucursal"
                @update:modelValue="clearAlerts(); clearFieldError('sucursal')"
              />

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Escolaridad</label>
                  <input
                    v-model="form.escolaridad"
                    class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 placeholder:text-slate-500
                           ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60
                           text-[13px] sm:text-[14px] md:text-[15px]"
                    placeholder="Escribe aquí"
                    @input="clearAlerts(); clearFieldError('escolaridad')"
                  />
                  <p v-if="errors.escolaridad" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.escolaridad }}</p>
                </div>

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Paquetería Office</label>
                  <input
                    v-model="form.office"
                    class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 placeholder:text-slate-500
                           ring-1 ring-black/5 outline-none transition
                           hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60
                           text-[13px] sm:text-[14px] md:text-[15px]"
                    placeholder="Básico / Intermedio / Avanzado"
                    @input="clearAlerts(); clearFieldError('office')"
                  />
                  <p v-if="errors.office" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.office }}</p>
                </div>
              </div>

              <!-- CV (opcional) -->
              <div class="pt-1">
                <div class="flex items-center justify-between gap-3">
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">
                    CV (PDF, opcional)
                  </label>
                  <div class="text-[11px] sm:text-[12px] font-semibold text-slate-500">Máx. 5MB</div>
                </div>

                <input ref="cvInput" type="file" accept="application/pdf,.pdf" class="hidden" @change="handleCvInput" :disabled="sending" />

                <div class="mt-2 flex flex-wrap items-center gap-2">
                  <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-4 py-2
                           text-[13px] sm:text-[14px] font-extrabold text-white transition hover:bg-slate-800 disabled:opacity-60"
                    :disabled="sending"
                    @click="cvInput?.click()"
                  >
                    <span>{{ hasCv ? 'Cambiar PDF' : 'Seleccionar PDF' }}</span>
                  </button>

                  <button
                    v-if="hasCv"
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-full bg-rose-600 px-4 py-2
                           text-[13px] sm:text-[14px] font-extrabold text-white transition hover:bg-rose-700 disabled:opacity-60"
                    :disabled="sending"
                    @click="removeCv"
                  >
                    <span>Quitar</span>
                  </button>
                </div>

                <div v-if="hasCv" class="mt-3 rounded-2xl bg-white/70 ring-1 ring-black/5 px-4 py-3 shadow-sm">
                  <p class="text-[12px] sm:text-[13px] font-extrabold text-slate-900 truncate">{{ cvName }}</p>
                  <p class="text-[11px] sm:text-[12px] text-slate-600">PDF listo para adjuntar al correo</p>
                </div>

                <p v-if="errors.cv" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.cv }}</p>
              </div>
            </div>
          </div>

          <!-- CUESTIONARIO -->
          <div class="rounded-3xl border border-black/5 bg-white/80 p-4 sm:p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3">
              <div class="text-[13px] sm:text-[14px] font-extrabold text-slate-900">Cuestionario</div>
              <div class="text-[11px] sm:text-[12px] font-semibold text-slate-500">Respuestas obligatorias</div>
            </div>

            <div class="mt-4 space-y-5">
              <!-- Q1 -->
              <div class="rounded-2xl bg-slate-50/80 ring-1 ring-black/5 p-4">
                <div class="font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">
                  1) ¿Has sido responsable directa del resguardo y control de efectivo en un trabajo anterior?
                  <span class="block font-semibold text-slate-600 text-[11px] sm:text-[12px] mt-1">(Cortes, caja, depósitos, arqueos)</span>
                </div>

                <div class="mt-3 flex flex-wrap items-center gap-4 text-[13px] sm:text-[14px]">
                  <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input v-model="form.p1_resguardo_efectivo" type="radio" value="si" name="p1_res" class="h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p1_resguardo_efectivo')" />
                    <span class="font-semibold">Sí</span>
                  </label>
                  <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input v-model="form.p1_resguardo_efectivo" type="radio" value="no" name="p1_res" class="h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p1_resguardo_efectivo')" />
                    <span class="font-semibold">No</span>
                  </label>
                </div>

                <p v-if="errors.p1_resguardo_efectivo" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p1_resguardo_efectivo }}</p>
              </div>

              <!-- Q2 -->
              <div class="rounded-2xl bg-slate-50/80 ring-1 ring-black/5 p-4">
                <div class="font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">
                  2) ¿Tienes experiencia integrando y validando expedientes completos de clientes o personal?
                </div>

                <div class="mt-3 flex flex-wrap items-center gap-4 text-[13px] sm:text-[14px]">
                  <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input v-model="form.p2_expedientes" type="radio" value="si" name="p2_exp" class="h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p2_expedientes')" />
                    <span class="font-semibold">Sí</span>
                  </label>
                  <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input v-model="form.p2_expedientes" type="radio" value="no" name="p2_exp" class="h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p2_expedientes')" />
                    <span class="font-semibold">No</span>
                  </label>
                </div>

                <p v-if="errors.p2_expedientes" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p2_expedientes }}</p>
              </div>

              <!-- Q3 -->
              <div class="rounded-2xl bg-slate-50/80 ring-1 ring-black/5 p-4">
                <div class="font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">
                  3) ¿Has realizado cuadres diarios de caja o cartera y cierre de turno?
                </div>

                <div class="mt-3 flex flex-wrap items-center gap-4 text-[13px] sm:text-[14px]">
                  <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input v-model="form.p3_cuadres_cierre" type="radio" value="si" name="p3_cua" class="h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p3_cuadres_cierre')" />
                    <span class="font-semibold">Sí</span>
                  </label>
                  <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input v-model="form.p3_cuadres_cierre" type="radio" value="no" name="p3_cua" class="h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p3_cuadres_cierre')" />
                    <span class="font-semibold">No</span>
                  </label>
                </div>

                <p v-if="errors.p3_cuadres_cierre" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p3_cuadres_cierre }}</p>
              </div>

              <!-- Q4 -->
              <div class="rounded-2xl bg-slate-50/80 ring-1 ring-black/5 p-4">
                <div class="font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">
                  4) Si al cierre del turno detectas un faltante de efectivo, tú normalmente…
                </div>

                <div class="mt-3 space-y-2 text-[13px] sm:text-[14px]">
                  <label class="flex items-start gap-2 cursor-pointer select-none">
                    <input v-model="form.p4_faltante" type="radio" value="detengo_reporto" name="p4_fal" class="mt-0.5 h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p4_faltante')" />
                    <span class="font-semibold">Detienes el cierre, documentas y reportas de inmediato</span>
                  </label>
                  <label class="flex items-start gap-2 cursor-pointer select-none">
                    <input v-model="form.p4_faltante" type="radio" value="ajusto" name="p4_fal" class="mt-0.5 h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p4_faltante')" />
                    <span class="font-semibold">Ajustas para cuadrar</span>
                  </label>
                  <label class="flex items-start gap-2 cursor-pointer select-none">
                    <input v-model="form.p4_faltante" type="radio" value="dejo_despues" name="p4_fal" class="mt-0.5 h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p4_faltante')" />
                    <span class="font-semibold">Lo dejas para el día siguiente</span>
                  </label>
                </div>

                <p v-if="errors.p4_faltante" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p4_faltante }}</p>

                <div class="mt-3 rounded-xl bg-white/80 px-3 py-2 ring-1 ring-black/5">
                  <div class="text-[11px] sm:text-[12px] font-semibold text-slate-500">Selección</div>
                  <div class="text-[12px] sm:text-[13px] font-extrabold text-slate-900">{{ p4Human }}</div>
                </div>
              </div>

              <!-- Q5 -->
              <div class="rounded-2xl bg-slate-50/80 ring-1 ring-black/5 p-4">
                <div class="font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">
                  5) Este puesto requiere orden extremo, apego a procesos y manejo de dinero todos los días.
                  <span class="block font-extrabold mt-1">¿Te sientes cómoda trabajando bajo esta responsabilidad?</span>
                </div>

                <div class="mt-3 flex flex-wrap items-center gap-4 text-[13px] sm:text-[14px]">
                  <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input v-model="form.p5_responsabilidad" type="radio" value="si" name="p5_res" class="h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p5_responsabilidad')" />
                    <span class="font-semibold">Sí</span>
                  </label>
                  <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input v-model="form.p5_responsabilidad" type="radio" value="no" name="p5_res" class="h-4 w-4 accent-emerald-500"
                           @change="clearAlerts(); clearFieldError('p5_responsabilidad')" />
                    <span class="font-semibold">No</span>
                  </label>
                </div>

                <p v-if="errors.p5_responsabilidad" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.p5_responsabilidad }}</p>
              </div>

              <!-- CTA -->
              <div class="pt-1">
                <button
                  type="button"
                  class="group w-full rounded-full py-4 font-extrabold text-white
                         shadow-[0_18px_40px_rgba(16,185,129,0.45)]
                         transition active:scale-[0.99] disabled:opacity-60 disabled:cursor-not-allowed
                         text-[14px] sm:text-[15px] md:text-[16px] lg:text-[18px]"
                  :class="canSend ? 'bg-emerald-500 hover:bg-emerald-600 hover:shadow-[0_22px_52px_rgba(16,185,129,0.55)]' : 'bg-emerald-500/70'"
                  :disabled="!canSend"
                  @click="handleSubmit"
                >
                  <span class="inline-flex items-center justify-center gap-2">
                    {{ sending ? 'Enviando...' : 'Postularse' }}
                    <span class="transition group-hover:translate-x-[2px]">→</span>
                  </span>
                </button>

                <div class="mt-3 text-[11px] sm:text-[12px] font-semibold text-slate-500">
                  Al enviar, tu CV (si lo adjuntas) se manda como PDF adjunto en el correo.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Container>
  </div>
</template>
