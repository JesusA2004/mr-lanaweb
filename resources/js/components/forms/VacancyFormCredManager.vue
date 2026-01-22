<script setup lang="ts">
    import { reactive } from 'vue'
    import Container from '@/components/ui/Container.vue'
    import SectionHeader from '@/components/ui/SectionHeader.vue'
    import FormAlert from '@/components/ui/FormAlert.vue'
    import DatePickerShadcn from '@/components/ui/DatePickerShadcn.vue'
    import NumericInput from '@/components/ui/NumericInput.vue'
    import SelectSucursales from '@/components/ui/SelectSucursales.vue'

    const emit = defineEmits<{ (e:'back'):void; (e:'close'):void }>()
    const bgSrc = '/img/vacantes/bg-manager-vacancy.png'

    const form = reactive({
      nombre: '',
      fecha_nacimiento: '',
      telefono: '',
      correo: '',
      sucursal: '',
      escolaridad: '',
      office: '',
      cartera: '',
      ventas: '',
      meta_mensual: '',
    })

    const errors = reactive<Record<string,string>>({})
    const submitError = reactive({ message: '' })
    const submitOk = reactive({ message: '' })

    function clearAlerts(){ submitError.message=''; submitOk.message='' }
    function validateEmail(v:string){ return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()) }

    function validate(){
      clearAlerts()
      Object.keys(errors).forEach(k=>delete errors[k])

      if(!form.nombre.trim()) errors.nombre='Campo obligatorio'
      if(!form.fecha_nacimiento) errors.fecha_nacimiento='Campo obligatorio'
      if(!form.telefono.trim()) errors.telefono='Campo obligatorio'
      if(form.telefono.trim().length!==10) errors.telefono='Deben ser 10 dígitos'
      if(!form.correo.trim()) errors.correo='Campo obligatorio'
      if(form.correo.trim() && !validateEmail(form.correo)) errors.correo='Correo inválido'
      if(!form.sucursal) errors.sucursal='Campo obligatorio'
      if(!form.escolaridad.trim()) errors.escolaridad='Campo obligatorio'
      if(!form.office.trim()) errors.office='Campo obligatorio'
      if(!form.cartera) errors.cartera='Campo obligatorio'
      if(!form.ventas) errors.ventas='Campo obligatorio'
      if(!form.meta_mensual.trim()) errors.meta_mensual='Campo obligatorio'

      return Object.keys(errors).length===0
    }

    async function submit(){
      if(!validate()){
        submitError.message='Revisar los campos marcados antes de enviar.'
        return
      }
      submitOk.message='Listo. La postulación se envió correctamente.'
    }
    </script>

    <template>
      <div class="w-full bg-white">
        <div class="relative w-full">
          <div class="relative h-[210px] sm:h-[230px] md:h-[250px] lg:h-[270px] xl:h-[290px] 2xl:h-[310px]">
            <img :src="bgSrc" alt="Vacante Gestor de Crédito" class="absolute inset-0 h-full w-full object-cover object-center" loading="lazy" draggable="false" />
            <div class="absolute inset-0 bg-gradient-to-b from-white/5 via-white/35 to-white" />

            <div class="absolute left-3 top-3 z-20">
              <button
                type="button"
                class="group inline-flex items-center gap-2 rounded-full bg-white/85 px-3 py-2 text-xs sm:text-sm font-extrabold text-slate-900
                       ring-1 ring-black/5 shadow-sm backdrop-blur transition hover:bg-white hover:shadow-[0_10px_22px_rgba(0,0,0,0.10)] active:scale-[0.99]"
                @click="emit('back')"
              >
                <span class="transition group-hover:-translate-x-[1px]">←</span>
                <span>Regresar</span>
              </button>
            </div>

            <div class="absolute right-3 top-3 z-20">
              <button
                type="button"
                class="grid h-9 w-9 place-items-center rounded-full bg-white/85 text-slate-900 ring-1 ring-black/5 shadow-sm backdrop-blur transition
                       hover:bg-white hover:shadow-[0_10px_22px_rgba(0,0,0,0.10)] active:scale-[0.98]"
                @click="emit('close')"
              >
                ✕
              </button>
            </div>

            <div class="absolute left-4 right-4 top-[58%] -translate-y-1/2 sm:left-6 sm:right-6">
              <h2 class="font-extrabold tracking-tight text-[#0b67a3] text-[28px] sm:text-[34px] md:text-[40px] lg:text-[46px] xl:text-[52px] 2xl:text-[56px]">
                Vendedor de crédito
              </h2>
              <ul class="mt-2 list-disc pl-5 text-slate-900 text-[12px] sm:text-[13px] md:text-[14px] lg:text-[15px] xl:text-[16px] space-y-1">
                <li>Colocación y seguimiento de crédito</li>
                <li>Prospección y cierre</li>
                <li>Gestión de cartera</li>
                <li>Metas mensuales</li>
              </ul>
            </div>
          </div>
        </div>

        <Container class="py-5 sm:py-6">
          <div class="space-y-4">
            <FormAlert v-if="submitError.message" variant="error" :message="submitError.message" />
            <FormAlert v-if="submitOk.message" variant="success" :message="submitOk.message" />

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
              <div class="space-y-4">
                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Nombre Apellidos</label>
                  <input v-model="form.nombre" class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]" @input="clearAlerts" />
                  <p v-if="errors.nombre" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.nombre }}</p>
                </div>

                <DatePickerShadcn v-model="form.fecha_nacimiento" label="Fecha de Nacimiento" placeholder="Selecciona fecha" :error="errors.fecha_nacimiento" @update:modelValue="clearAlerts" />

                <NumericInput v-model="form.telefono" label="Teléfono" placeholder="10 dígitos" :max-length="10" :error="errors.telefono" @update:modelValue="clearAlerts" />

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Correo</label>
                  <input v-model="form.correo" type="email" class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]" @input="clearAlerts" />
                  <p v-if="errors.correo" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.correo }}</p>
                </div>

                <SelectSucursales v-model="form.sucursal" label="Sucursal" placeholder="Selecciona" :error="errors.sucursal" @update:modelValue="clearAlerts" />
              </div>

              <div class="space-y-4">
                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Escolaridad</label>
                  <input v-model="form.escolaridad" class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]" @input="clearAlerts" />
                  <p v-if="errors.escolaridad" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.escolaridad }}</p>
                </div>

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Nivel de paquetería Office</label>
                  <input v-model="form.office" class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]" @input="clearAlerts" />
                  <p v-if="errors.office" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.office }}</p>
                </div>

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">¿Has manejado cartera?</label>
                  <div class="mt-2 flex items-center gap-4 text-[13px] sm:text-[14px]">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                      <input v-model="form.cartera" type="radio" value="si" name="cartera" class="h-4 w-4 accent-emerald-500" @change="clearAlerts" />
                      <span class="font-semibold">Sí</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                      <input v-model="form.cartera" type="radio" value="no" name="cartera" class="h-4 w-4 accent-emerald-500" @change="clearAlerts" />
                      <span class="font-semibold">No</span>
                    </label>
                  </div>
                  <p v-if="errors.cartera" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.cartera }}</p>
                </div>

                <div>
                  <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">¿Experiencia en ventas?</label>
                  <div class="mt-2 flex items-center gap-4 text-[13px] sm:text-[14px]">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                      <input v-model="form.ventas" type="radio" value="si" name="ventas" class="h-4 w-4 accent-emerald-500" @change="clearAlerts" />
                      <span class="font-semibold">Sí</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                      <input v-model="form.ventas" type="radio" value="no" name="ventas" class="h-4 w-4 accent-emerald-500" @change="clearAlerts" />
                      <span class="font-semibold">No</span>
                    </label>
                  </div>
                  <p v-if="errors.ventas" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.ventas }}</p>
                </div>

                <NumericInput
                  v-model="form.meta_mensual"
                  label="Meta mensual aproximada"
                  placeholder="Solo números"
                  :error="errors.meta_mensual"
                  @update:modelValue="clearAlerts"
                />

                <div class="pt-2">
                  <button
                    type="button"
                    class="group w-full rounded-full bg-emerald-500 py-4 text-white font-extrabold shadow-[0_18px_40px_rgba(16,185,129,0.45)]
                           transition hover:bg-emerald-600 hover:shadow-[0_22px_52px_rgba(16,185,129,0.55)] active:scale-[0.99]
                           text-[14px] sm:text-[15px] md:text-[16px] lg:text-[18px]"
                    @click="submit"
                  >
                    <span class="inline-flex items-center justify-center gap-2">
                      Postularse <span class="transition group-hover:translate-x-[2px]">→</span>
                    </span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </Container>
      </div>
    </template>
