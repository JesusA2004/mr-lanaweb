<script setup lang="ts">
    import { computed, onBeforeUnmount, onMounted, reactive, watch } from 'vue'

    type Branch = { id?: string | number; name?: string; nombre?: string; label?: string; value?: any } | string
    type ModalContext = 'impulsat' | 'impulsa_negocio'

    const props = withDefaults(
        defineProps<{
            open: boolean
            branches: Branch[]
            context?: ModalContext
            sending?: boolean
        }>(),
        {
            context: 'impulsat',
            sending: false,
        }
    )

    const emit = defineEmits<{
        (e: 'close'): void
        (e: 'submit', payload: any): void
    }>()

    const form = reactive({
        branch: '',
        nombres: '',
        apellido1: '',
        apellido2: '',
        email: '',
        telefono: '',
        direccion: '',
        negocioFisico: 'Si' as 'Si' | 'No',
        // IMPULSA TU NEGOCIO
        giroNegocio: '',
        // IMPULSA.T
        empleoCuenta: '' as '' | 'Formal' | 'Informal',
        tipoEmpleo: '',
    })

    const errors = reactive<Record<string, string>>({})

    const titleId = 'modal-business-loan-title'

    const branchOptions = computed(() => {
        return (props.branches || []).map((b: any) => {
            if (typeof b === 'string') return { key: b, label: b, value: b }
            const label = b.name ?? b.nombre ?? b.label ?? String(b.value ?? b.id ?? '')
            const value = b.value ?? b.id ?? label
            return { key: String(value), label: String(label), value: String(value) }
        })
    })

    const isImpulsaNegocio = computed(() => props.context === 'impulsa_negocio')
    const isImpulsat = computed(() => props.context === 'impulsat')

    watch(
        () => form.negocioFisico,
        () => {
            // Si no tiene negocio físico, no pedimos giro (y limpiamos)
            if (form.negocioFisico !== 'Si') {
            form.giroNegocio = ''
            errors.giroNegocio = ''
            }
        }
    )

    watch(
        () => form.empleoCuenta,
        () => {
            // Si aún no selecciona empleo, limpia tipo
            if (!form.empleoCuenta) {
            form.tipoEmpleo = ''
            errors.tipoEmpleo = ''
            }
        }
    )

    function validate() {
        Object.keys(errors).forEach((k) => (errors[k] = ''))
        // Base
        if (!form.branch) errors.branch = 'Selecciona una sucursal.'
        if (!form.nombres.trim()) errors.nombres = 'Escribe tu nombre.'
        if (!form.apellido1.trim()) errors.apellido1 = 'Escribe tu 1° apellido.'
        if (!form.email.trim()) errors.email = 'Escribe tu correo.'
        if (!form.telefono.trim()) errors.telefono = 'Escribe tu teléfono.'
        if (!form.direccion.trim()) errors.direccion = 'Escribe tu dirección.'
        // Reglas por contexto
        if (isImpulsaNegocio.value) {
            // Solo si sí tiene negocio físico
            if (form.negocioFisico === 'Si' && !form.giroNegocio.trim()) {
            errors.giroNegocio = 'Indica el giro de tu negocio.'
            }
        }
        if (isImpulsat.value) {
            if (!form.empleoCuenta) errors.empleoCuenta = 'Selecciona una opción.'
            if (form.empleoCuenta && !form.tipoEmpleo.trim()) errors.tipoEmpleo = 'Indica el tipo de empleo.'
        }
        return Object.values(errors).every((v) => !v)
    }

    function onSubmit() {
        if (props.sending) return
        if (!validate()) return
        // Payload: manda todo; lo que no aplique se va vacío
        emit('submit', { ...form, context: props.context })
    }

    function close() {
        emit('close')
    }

    function onKeydown(e: KeyboardEvent) {
        if (!props.open) return
        if (e.key === 'Escape') close()
    }

    onMounted(() => document.addEventListener('keydown', onKeydown))
    onBeforeUnmount(() => document.removeEventListener('keydown', onKeydown))
</script>

<template>
    <div v-if="open" class="fixed inset-0 z-[9999]">
        <!-- Backdrop -->
        <button type="button" class="absolute inset-0 bg-black/70" aria-label="Cerrar" @click="close" />

        <!-- Wrapper -->
        <div class="relative mx-auto flex min-h-full items-center justify-center p-3 sm:p-6 lg:p-10">
            <div class="w-full max-w-[760px] overflow-hidden rounded-2xl bg-white shadow-2xl"
            role="dialog" aria-modal="true" :aria-labelledby="titleId">
                <!-- Header -->
                <div class="relative border-b border-gray-100 px-4 sm:px-7 py-4 sm:py-6">
                    <h2 :id="titleId" class="text-center text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900">
                        Solicita tu crédito
                    </h2>

                    <button type="button" class="absolute right-3 top-3 sm:right-4 sm:top-4 
                    rounded-full p-2 text-gray-500 hover:bg-gray-100 
                    hover:text-gray-800 transition"
                    aria-label="Cerrar" @click="close">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body scroll -->
                <div class="max-h-[calc(100vh-8.5rem)] sm:max-h-[calc(100vh-10rem)] overflow-y-auto">
                    <form class="px-4 sm:px-7 py-4 sm:py-6" @submit.prevent="onSubmit">
                        <div class="space-y-4 sm:space-y-6">
                            <!-- Sucursal -->
                            <div>
                                <label class="block text-sm sm:text-base font-bold text-gray-900 mb-2">Elige tu sucursal</label>
                                <select v-model="form.branch" class="w-full rounded-xl 
                                bg-gray-100 px-4 py-3 text-gray-900 outline-none ring-1 
                                ring-transparent focus:bg-white focus:ring-2 
                                focus:ring-sky-300 transition">
                                    <option value="" disabled>Selecciona una sucursal</option>
                                    <option v-for="b in branchOptions" :key="b.key" :value="b.value">
                                        {{ b.label }}
                                    </option>
                                </select>
                                <p v-if="errors.branch" class="mt-1 text-xs sm:text-sm text-red-600">{{ errors.branch }}</p>
                            </div>

                            <!-- Nombres -->
                            <div>
                                <label class="block text-sm sm:text-base font-bold text-gray-900 mb-2">Nombre(s)</label>
                                <input v-model="form.nombres" type="text"
                                placeholder="Escribe tu nombre"
                                class="w-full rounded-xl bg-gray-100 px-4 py-3 text-gray-900 
                                outline-none ring-1 ring-transparent
                                focus:bg-white focus:ring-2 focus:ring-sky-300 transition"/>
                                <p v-if="errors.nombres" class="mt-1 text-xs sm:text-sm text-red-600">{{ errors.nombres }}</p>
                            </div>

                            <!-- Apellidos -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <div>
                                    <label class="block text-sm sm:text-base font-bold text-gray-900 mb-2">1° Apellido</label>
                                    <input v-model="form.apellido1" type="text"
                                    placeholder="Escribe aquí" class="w-full rounded-xl 
                                    bg-gray-100 px-4 py-3 text-gray-900 outline-none 
                                    ring-1 ring-transparent focus:bg-white focus:ring-2 
                                    focus:ring-sky-300 transition"/>
                                    <p v-if="errors.apellido1" class="mt-1 text-xs sm:text-sm text-red-600">{{ errors.apellido1 }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm sm:text-base font-bold text-gray-900 mb-2">2° Apellido</label>
                                    <input v-model="form.apellido2" type="text"
                                    placeholder="Escribe aquí" class="w-full rounded-xl 
                                    bg-gray-100 px-4 py-3 text-gray-900 outline-none 
                                    ring-1 ring-transparent focus:bg-white focus:ring-2 
                                    focus:ring-sky-300 transition"/>
                                </div>
                            </div>

                            <!-- Correo -->
                            <div>
                                <label class="block text-sm sm:text-base font-bold text-gray-900 mb-2">Correo electrónico</label>
                                <input v-model="form.email" type="email"
                                placeholder="ejemplo@gmail.com"
                                class="w-full rounded-xl bg-gray-100 px-4 py-3 
                                text-gray-900 outline-none ring-1 ring-transparent
                                focus:bg-white focus:ring-2 focus:ring-sky-300 
                                transition"/>
                                <p v-if="errors.email" class="mt-1 text-xs sm:text-sm text-red-600">{{ errors.email }}</p>
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label class="block text-sm sm:text-base font-bold text-gray-900 mb-2">Teléfono</label>
                                <input v-model="form.telefono" type="tel"
                                placeholder="Escribe aquí"
                                class="w-full rounded-xl bg-gray-100 px-4 py-3 
                                text-gray-900 outline-none ring-1 ring-transparent
                                focus:bg-white focus:ring-2 focus:ring-sky-300 
                                transition"/>
                                <p v-if="errors.telefono" class="mt-1 text-xs sm:text-sm text-red-600">{{ errors.telefono }}</p>
                            </div>

                            <!-- Dirección -->
                            <div>
                                <label class="block text-sm sm:text-base font-bold text-gray-900 mb-2">Dirección</label>
                                <input v-model="form.direccion" type="text"
                                placeholder="Escribe aquí"
                                class="w-full rounded-xl bg-gray-100 px-4 py-3 
                                text-gray-900 outline-none ring-1 ring-transparent
                                focus:bg-white focus:ring-2 focus:ring-sky-300 
                                transition"/>
                                <p v-if="errors.direccion" class="mt-1 text-xs sm:text-sm text-red-600">{{ errors.direccion }}</p>
                            </div>

                            <!-- Negocio físico -->
                            <div class="pt-1">
                                <p class="text-sm sm:text-base font-extrabold text-gray-900 mb-3">¿Tienes Negocio Físico?</p>
                                <div class="flex flex-wrap items-center gap-6 sm:gap-8">
                                    <label class="inline-flex items-center gap-3 cursor-pointer">
                                        <span class="grid h-6 w-6 place-items-center 
                                        rounded-full border-2 border-lime-500"
                                        :class="form.negocioFisico === 'Si' ? 'bg-lime-500' : 'bg-white'">
                                            <span class="h-2.5 w-2.5 rounded-full bg-white" v-if="form.negocioFisico === 'Si'"></span>
                                        </span>
                                        <input class="hidden" type="radio" value="Si" v-model="form.negocioFisico" />
                                        <span class="text-sm sm:text-base font-semibold text-gray-900">Sí</span>
                                    </label>

                                    <label class="inline-flex items-center gap-3 cursor-pointer">
                                        <span class="grid h-6 w-6 place-items-center 
                                        rounded-full border-2 border-gray-300"
                                        :class="form.negocioFisico === 'No' ? 'bg-gray-900 border-gray-900' : 'bg-white'">
                                            <span class="h-2.5 w-2.5 rounded-full bg-white" v-if="form.negocioFisico === 'No'"></span>
                                        </span>
                                        <input class="hidden" type="radio" value="No" v-model="form.negocioFisico" />
                                        <span class="text-sm sm:text-base font-semibold text-gray-900">No</span>
                                    </label>
                                </div>
                            </div>

                            <!-- IMPULSA TU NEGOCIO: Giro del negocio (solo si negocio físico = Sí) -->
                            <div v-if="isImpulsaNegocio && form.negocioFisico === 'Si'">
                                <label class="block text-sm sm:text-base font-bold text-gray-900 mb-2">Giro del negocio</label>
                                <input v-model="form.giroNegocio" type="text"
                                placeholder="Ej. Abarrotes, estética, taller, comida, etc."
                                class="w-full rounded-xl bg-gray-100 px-4 py-3 
                                text-gray-900 outline-none ring-1 ring-transparent
                                focus:bg-white focus:ring-2 focus:ring-sky-300 
                                transition"/>
                                <p v-if="errors.giroNegocio" class="mt-1 text-xs sm:text-sm text-red-600">{{ errors.giroNegocio }}</p>
                            </div>

                            <!-- IMPULSA.T: empleo formal/informal + tipo -->
                            <div v-if="isImpulsat" class="space-y-4">
                                <div class="pt-1">
                                    <p class="text-sm sm:text-base font-extrabold text-gray-900 mb-3">¿Cuenta con empleo formal o informal?</p>
                                    <div class="flex flex-wrap items-center gap-6 sm:gap-8">
                                        <label class="inline-flex items-center gap-3 cursor-pointer">
                                            <span class="grid h-6 w-6 place-items-center 
                                            rounded-full border-2 border-sky-400"
                                            :class="form.empleoCuenta === 'Formal' ? 'bg-sky-500 border-sky-500' : 'bg-white'">
                                                <span class="h-2.5 w-2.5 rounded-full bg-white" v-if="form.empleoCuenta === 'Formal'"></span>
                                            </span>
                                            <input class="hidden" type="radio" value="Formal" v-model="form.empleoCuenta" />
                                            <span class="text-sm sm:text-base font-semibold text-gray-900">Formal</span>
                                        </label>

                                        <label class="inline-flex items-center gap-3 cursor-pointer">
                                            <span class="grid h-6 w-6 place-items-center rounded-full border-2 border-sky-400"
                                            :class="form.empleoCuenta === 'Informal' ? 'bg-sky-500 border-sky-500' : 'bg-white'">
                                                <span class="h-2.5 w-2.5 rounded-full bg-white" v-if="form.empleoCuenta === 'Informal'"></span>
                                            </span>
                                            <input class="hidden" type="radio" value="Informal" v-model="form.empleoCuenta" />
                                            <span class="text-sm sm:text-base font-semibold text-gray-900">Informal</span>
                                        </label>
                                    </div>
                                    <p v-if="errors.empleoCuenta" class="mt-1 text-xs sm:text-sm text-red-600">{{ errors.empleoCuenta }}</p>
                                </div>

                                <div v-if="form.empleoCuenta">
                                    <label class="block text-sm sm:text-base font-bold text-gray-900 mb-2">Tipo de empleo</label>
                                    <input v-model="form.tipoEmpleo" type="text"
                                    placeholder="Ej. Empleado, comerciante, chofer, etc."
                                    class="w-full rounded-xl bg-gray-100 px-4 py-3 
                                    text-gray-900 outline-none ring-1 ring-transparent
                                    focus:bg-white focus:ring-2 focus:ring-sky-300 
                                    transition"/>
                                    <p v-if="errors.tipoEmpleo" class="mt-1 text-xs sm:text-sm text-red-600">{{ errors.tipoEmpleo }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- CTA sticky -->
                        <button type="submit" :disabled="props.sending"
                        class="w-full rounded-xl bg-lime-500 
                        py-4 text-lg sm:text-xl font-extrabold text-white
                        hover:bg-lime-600 transition
                        disabled:opacity-60 disabled:cursor-not-allowed">
                            <span v-if="!props.sending">Enviar</span>
                            <span v-else>Enviando...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
