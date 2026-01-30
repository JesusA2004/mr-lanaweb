<script setup lang="ts">
    import { computed, ref, onMounted, onBeforeUnmount } from 'vue'
    import { SUCURSALES } from '@/lib/sucursales'

    const props = withDefaults(
        defineProps<{
            modelValue: string
            label?: string
            placeholder?: string
            error?: string
            disabled?: boolean
            required?: boolean
        }>(),
        {
            label: 'Sucursal',
            placeholder: 'Selecciona una sucursal',
            disabled: false,
            required: false,
        }
    )

    const emit = defineEmits<{
        (e: 'update:modelValue', value: string): void
        (e: 'blur'): void
    }>()

    const open = ref(false)
    const container = ref<HTMLElement | null>(null)
    const search = ref('')

    function handleClickOutside(e: MouseEvent) {
        if (!container.value) return
        if (!container.value.contains(e.target as Node)) {
            open.value = false
            emit('blur')
        }
    }

    onMounted(() => {
        document.addEventListener('click', handleClickOutside)
    })

    onBeforeUnmount(() => {
        document.removeEventListener('click', handleClickOutside)
    })

    const filteredSucursales = computed(() => {
        if (!search.value) return SUCURSALES
        return SUCURSALES.filter(s =>
            s.toLowerCase().includes(search.value.toLowerCase())
        )
    })

    const selectedLabel = computed(() => {
        return props.modelValue || props.placeholder
    })

    function selectSucursal(s: string) {
        emit('update:modelValue', s)
        open.value = false
        search.value = ''
    }
</script>

<template>
    <div ref="container" class="w-full relative">
        <!-- Label -->
        <label v-if="label" class="block mb-1 text-[12px] sm:text-[13px]
        font-semibold text-black/70">
            {{ label }}
            <span v-if="required" class="text-rose-600">*</span>
        </label>

        <!-- Trigger -->
        <button type="button" :disabled="disabled" @click="open = !open"
        class="w-full flex items-center justify-between rounded-full bg-white
        px-4 py-3 text-[13px] sm:text-[14px] font-medium ring-1 ring-black/10
        transition hover:ring-[#1879B3]/40 focus:outline-none focus:ring-2
        focus:ring-[#1879B3] disabled:bg-slate-100 disabled:text-black/40
        disabled:cursor-not-allowed">
            <span :class="modelValue ? 'text-black' : 'text-black/40'">
                {{ selectedLabel }}
            </span>

            <span class="ml-3 text-black/50 text-[12px] transition"
            :class="open ? 'rotate-180' : ''">
                ▼
            </span>
        </button>

        <!-- Dropdown -->
        <transition enter-active-class="transition duration-150 ease-out"
        enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100"
        leave-active-class="transition duration-100 ease-in"
        leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="open" class="absolute z-50 mt-2 w-full rounded-2xl
            bg-white ring-1 ring-black/10 shadow-xl">
                <!-- Buscador -->
                <div class="p-2">
                    <input v-model="search" type="text" placeholder="Buscar sucursal…"
                    class="w-full rounded-full px-3 py-2 text-[13px] ring-1 ring-black/10
                    outline-none focus:ring-2 focus:ring-[#1879B3]"/>
                </div>

                <!-- Lista -->
                <ul class="max-h-56 overflow-auto">
                    <li v-for="s in filteredSucursales" :key="s" @click="selectSucursal(s)"
                    class="cursor-pointer px-4 py-2 text-[13px] sm:text-[14px] transition
                    hover:bg-[#1879B3]/10 hover:text-[#1879B3]"
                    :class="modelValue === s
                    ? 'bg-[#1879B3]/15 font-semibold text-[#1879B3]'
                    : 'text-black/80'">
                        {{ s }}
                    </li>

                    <!-- Sin resultados -->
                    <li v-if="filteredSucursales.length === 0"
                    class="px-4 py-3 text-[12px] text-black/40 italic">
                        Sin resultados
                    </li>
                </ul>
            </div>
        </transition>

        <!-- Error -->
        <p v-if="error" class="mt-1 text-[11px] sm:text-[12px] font-semibold text-rose-600">
            {{ error }}
        </p>
    </div>
</template>
