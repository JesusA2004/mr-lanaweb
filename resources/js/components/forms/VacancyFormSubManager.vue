<script setup lang="ts">
    import { computed, ref } from 'vue'
    import Container from '@/components/ui/Container.vue'
    import FormAlert from '@/components/ui/FormAlert.vue'
    import DatePickerShadcn from '@/components/ui/DatePickerShadcn.vue'
    import SelectSucursales from '@/components/ui/SelectSucursales.vue'
    import { swalNotify } from '@/lib/swal'
    import { useVacancySubManager } from '@/composables/useVacancySubManager'

    const emit = defineEmits<{ (e: 'back'): void; (e: 'close'): void }>()
    const bgSrc = '/img/vacantes/bg-manager-vacancy.png'

    const {
        form,
        errors,
        blockedByP1,
        blockMessage,
        submitError,
        submitOk,
        cvName,
        onCvChange,
        onTelefonoInput,
        onExperienciaInput,
        clearFieldError,
        clearAlerts,
        sending,
        submit,
    } = useVacancySubManager('/api/vacantes/subgerente')

    const submitDisabled = computed(() => sending.value || blockedByP1.value)
    const cvInput = ref<HTMLInputElement | null>(null)
    const hasCv = computed(() => !!cvName.value)

    function handleCvInput(e: Event) {
        const input = e.target as HTMLInputElement
        const file = input.files?.[0] || null
        onCvChange(file)
        input.value = ''
    }

    function removeCv() {
        onCvChange(null)          // limpia cvFile/cvName y error cv
        if (cvInput.value) cvInput.value.value = '' // por si el browser guarda algo
    }

    async function handleSubmit() {
        // si está bloqueado, notifícalo y listo
        if (blockedByP1.value) {
            await swalNotify(
            'warning',
            blockMessage.value || 'Para este puesto necesitamos experiencia directa con cartera de crédito.'
            )
            return
        }
        const result = await submit()
        if (result.ok) {
            // cierra el modal primero para que el usuario vea el resultado “en el sitio”
            emit('close')
            // opcional: limpiamos alerts locales (para que cuando vuelvan a abrir no salga el ok)
            clearAlerts()
            await swalNotify('success', result.message, 'Postulación enviada')
            return
        }
        await swalNotify('error', result.message, 'No se pudo enviar')
    }
</script>

<template>
    <div class="w-full bg-white">
        <!-- HEADER -->
        <div class="relative w-full">
            <div class="relative h-[210px] sm:h-[230px] md:h-[250px] lg:h-[270px] xl:h-[290px] 2xl:h-[310px]">
                <img :src="bgSrc" class="absolute inset-0 h-full w-full object-cover object-center"
                loading="lazy" draggable="false"/>
                <div class="absolute inset-0 bg-gradient-to-b from-white/5 via-white/35 to-white" />

                <div class="absolute left-3 top-3 z-20">
                    <button type="button" class="group inline-flex items-center gap-2 rounded-full
                    bg-white/85 px-3 py-2 text-xs sm:text-sm font-extrabold text-slate-900 ring-1
                    ring-black/5 shadow-sm backdrop-blur transition hover:bg-white
                    hover:shadow-[0_10px_22px_rgba(0,0,0,0.10)] active:scale-[0.99] disabled:opacity-60"
                    :disabled="sending" @click="emit('back')">
                        <span class="transition group-hover:-translate-x-[1px]">←</span>
                        <span>Regresar</span>
                    </button>
                </div>

                <div class="absolute right-3 top-3 z-20">
                    <button type="button" class="grid h-9 w-9 place-items-center rounded-full bg-black/85
                    text-white ring-1 ring-black/5 shadow-sm backdrop-blur transition hover:bg-black
                    hover:shadow-[0_10px_22px_rgba(0,0,0,0.10)] active:scale-[0.98] disabled:opacity-60"
                    :disabled="sending" @click="emit('close')" aria-label="Cerrar">
                        ✕
                    </button>
                </div>

                <div class="absolute left-4 right-4 top-[58%] -translate-y-1/2 sm:left-6 sm:right-6">
                    <h2 class="font-extrabold tracking-tight text-[#0b67a3] text-[28px] sm:text-[34px]
                    md:text-[40px] lg:text-[46px] xl:text-[52px] 2xl:text-[56px]">
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
                <!-- ALERTS -->
                <FormAlert v-if="submitError" variant="error" :message="submitError" />
                <!-- BLOQUEO POR P1 -->
                <FormAlert v-if="blockMessage" variant="error" :message="blockMessage" />

                <!-- GRID -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                    <!-- LEFT -->
                    <div class="space-y-4">
                        <section class="rounded-3xl bg-slate-50 ring-1 ring-black/5 p-4 sm:p-5">
                            <h3 class="text-sm sm:text-base font-extrabold text-slate-900 mb-4">Datos del candidato</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Nombre completo</label>
                                    <input v-model="form.nombre" class="mt-1 w-full rounded-2xl
                                    bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5
                                    outline-none transition hover:ring-black/10 focus:ring-2
                                    focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                                    @input="clearAlerts(); clearFieldError('nombre')"/>
                                    <p v-if="errors.nombre" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.nombre }}</p>
                                </div>

                                <!-- Calendario para Fecha de Nacimiento -->
                                <DatePickerShadcn v-model="form.fecha_nacimiento" label="Fecha de Nacimiento"
                                placeholder="Selecciona fecha" :error="errors.fecha_nacimiento"
                                @update:modelValue="clearAlerts(); clearFieldError('fecha_nacimiento')"/>

                                <!-- Teléfono -->
                                <div>
                                    <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Teléfono</label>
                                    <input :value="form.telefono" inputmode="numeric" autocomplete="tel"
                                    placeholder="Telefono a 10 dígitos" maxlength="10" class="mt-1 w-full
                                    rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900 ring-1
                                    ring-black/5 outline-none transition hover:ring-black/10 focus:ring-2
                                    focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                                    @input="onTelefonoInput" @paste="onTelefonoInput"/>
                                    <p class="mt-1 text-[11px] sm:text-[12px] text-slate-500">Solo números (10)</p>
                                    <p v-if="errors.telefono" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.telefono }}</p>
                                </div>

                                <div>
                                    <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Correo</label>
                                    <input  v-model="form.correo" type="email" placeholder="usuario@dominio.com"
                                    class="mt-1 w-full rounded-2xl bg-slate-100/70 px-4 py-3 text-slate-900
                                    ring-1 ring-black/5 outline-none transition hover:ring-black/10
                                    focus:ring-2 focus:ring-emerald-400/60 text-[13px] sm:text-[14px]
                                    md:text-[15px]" @input="clearAlerts(); clearFieldError('correo')"/>
                                    <p v-if="errors.correo" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.correo }}</p>
                                </div>

                                <SelectSucursales v-model="form.sucursal" label="Sucursal"
                                placeholder="Selecciona" :error="errors.sucursal"
                                @update:modelValue="clearAlerts(); clearFieldError('sucursal')"/>
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
                                    <input v-model="form.escolaridad" class="mt-1 w-full rounded-2xl
                                    bg-slate-100/70 px-4 py-3 text-slate-900 ring-1 ring-black/5
                                    outline-none transition hover:ring-black/10 focus:ring-2
                                    focus:ring-emerald-400/60 text-[13px] sm:text-[14px] md:text-[15px]"
                                    @input="clearAlerts(); clearFieldError('escolaridad')"/>
                                    <p v-if="errors.escolaridad" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.escolaridad }}</p>
                                </div>

                                <div>
                                    <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Nivel de paquetería Office</label>
                                    <input v-model="form.office" class="mt-1 w-full rounded-2xl bg-slate-100/70
                                    px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                                    hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px]
                                    sm:text-[14px] md:text-[15px]" @input="clearAlerts(); clearFieldError('office')"/>
                                    <p v-if="errors.office" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.office }}</p>
                                </div>

                                <!-- Experiencia -->
                                <div>
                                    <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">Años de experiencia</label>
                                    <input :value="form.experiencia_anios" inputmode="numeric"
                                    placeholder="Solo números" class="mt-1 w-full rounded-2xl bg-slate-100/70
                                    px-4 py-3 text-slate-900 ring-1 ring-black/5 outline-none transition
                                    hover:ring-black/10 focus:ring-2 focus:ring-emerald-400/60 text-[13px]
                                    sm:text-[14px] md:text-[15px]" @input="onExperienciaInput"
                                    @paste="onExperienciaInput"/>
                                    <p v-if="errors.experiencia_anios" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.experiencia_anios }}</p>
                                </div>

                                <div>
                                    <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">¿Liderazgo?</label>
                                    <div class="mt-2 flex items-center gap-4 text-[13px] sm:text-[14px]">
                                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                            <input v-model="form.liderazgo" type="radio" value="si"
                                            name="liderazgo" class="h-4 w-4 accent-emerald-500"
                                            @change="clearAlerts(); clearFieldError('liderazgo')"/>
                                            <span class="font-semibold">Sí</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                            <input v-model="form.liderazgo" type="radio" value="no"
                                            name="liderazgo" class="h-4 w-4 accent-emerald-500"
                                            @change="clearAlerts(); clearFieldError('liderazgo')"/>
                                            <span class="font-semibold">No</span>
                                        </label>
                                    </div>
                                    <p v-if="errors.liderazgo" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">{{ errors.liderazgo }}</p>
                                </div>

                                <!-- CV -->
                                <div>
                                    <label class="block font-extrabold text-slate-900 text-[12px] sm:text-[13px] md:text-[14px]">
                                        CV (PDF, opcional)
                                    </label>

                                    <!-- input real oculto -->
                                    <input ref="cvInput" type="file" accept="application/pdf,.pdf"
                                    class="hidden" @change="handleCvInput" :disabled="sending"/>

                                    <!-- acciones -->
                                    <div class="mt-2 flex flex-wrap items-center gap-2">
                                        <button type="button" class="inline-flex items-center justify-center
                                        gap-2 rounded-full bg-slate-900 px-4 py-2
                                        text-[13px] sm:text-[14px] font-extrabold text-white
                                        transition hover:bg-slate-800 disabled:opacity-60"
                                        :disabled="sending" @click="cvInput?.click()">
                                            <!-- icono upload -->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                                <path d="M7 10l5-5 5 5"/>
                                                <path d="M12 5v14"/>
                                            </svg>
                                            <span>{{ hasCv ? 'Cambiar PDF' : 'Seleccionar PDF' }}</span>
                                        </button>

                                        <button v-if="hasCv" type="button" class="inline-flex items-center
                                        justify-center gap-2 rounded-full bg-rose-600 px-4 py-2
                                        text-[13px] sm:text-[14px] font-extrabold text-white
                                        transition hover:bg-rose-700 disabled:opacity-60"
                                        :disabled="sending" @click="removeCv">
                                            <!-- icono trash -->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18"/>
                                                <path d="M8 6V4h8v2"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6"/>
                                                <path d="M14 11v6"/>
                                            </svg>
                                            <span>Quitar</span>
                                        </button>
                                    </div>

                                    <!-- tarjeta del archivo -->
                                    <div v-if="hasCv" class="mt-3 flex items-center justify-between gap-3
                                    rounded-2xl bg-white/70 ring-1 ring-black/5 px-4 py-3 shadow-sm">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <!-- icono PDF -->
                                            <div class="grid h-10 w-10 place-items-center rounded-2xl bg-rose-50 ring-1 ring-rose-100 shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                    <path d="M14 2v6h6"/>
                                                    <path d="M8 13h3"/>
                                                    <path d="M8 17h6"/>
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-[12px] sm:text-[13px] font-extrabold text-slate-900 truncate">
                                                    {{ cvName }}
                                                </p>
                                                <p class="text-[11px] sm:text-[12px] text-slate-600">
                                                    PDF cargado y listo para enviar
                                                </p>
                                            </div>
                                        </div>

                                        <button type="button" class="grid h-9 w-9 place-items-center
                                        rounded-full bg-slate-900 text-white
                                        transition hover:bg-slate-800 disabled:opacity-60"
                                        :disabled="sending" @click="removeCv" aria-label="Quitar PDF"
                                        title="Quitar PDF">
                                            ✕
                                        </button>
                                    </div>

                                    <p v-if="errors.cv" class="mt-2 text-[11px] sm:text-[12px] font-semibold text-rose-600">
                                        {{ errors.cv }}
                                    </p>

                                    <!-- hint cuando no hay cv -->
                                    <p v-if="!hasCv" class="mt-2 text-[11px] sm:text-[12px] text-slate-500">
                                        Solo PDF. Máximo 5MB.
                                    </p>
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
                                    <input v-model="form.p1_cartera" type="radio" value="si"
                                    name="p1_cartera" class="h-4 w-4 accent-emerald-500"
                                    @change="clearAlerts(); clearFieldError('p1_cartera')"/>
                                    <span class="font-semibold">Sí</span>
                                </label>
                                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                    <input v-model="form.p1_cartera" type="radio" value="no"
                                    name="p1_cartera" class="h-4 w-4 accent-emerald-500"
                                    @change="clearAlerts(); clearFieldError('p1_cartera')"/>
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
                        <button type="button" :disabled="submitDisabled" class="group w-full rounded-full py-4
                        font-extrabold text-white shadow-[0_18px_40px_rgba(16,185,129,0.45)]
                        transition active:scale-[0.99] disabled:opacity-60 disabled:cursor-not-allowed
                        text-[14px] sm:text-[15px] md:text-[16px] lg:text-[18px]"
                        :class="  submitDisabled ? 'bg-emerald-500/70'
                        : 'bg-emerald-500 hover:bg-emerald-600 hover:shadow-[0_22px_52px_rgba(16,185,129,0.55)]'"
                        @click="handleSubmit">
                            <span class="inline-flex items-center justify-center gap-2">
                                {{ sending ? 'Enviando...' : blockedByP1 ? 'Requiere experiencia en cartera' : 'Postularse' }}
                                <span class="transition group-hover:translate-x-[2px]">→</span>
                            </span>
                        </button>

                        <p v-if="blockedByP1 && blockMessage" class="mt-2 text-[11px] sm:text-[12px] text-slate-600">
                        {{ blockMessage }}
                        </p>
                    </div>
                </section>
            </div>
        </Container>
    </div>
</template>
