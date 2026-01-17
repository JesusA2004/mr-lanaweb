<script setup lang="ts">
    import { ref } from 'vue'
    
    interface Branch {
        id: string | number
        name: string
    }
    
    interface Props {
        branches: Branch[]
        showBusinessToggle?: boolean
        frequency?: 'semanal'
        submitLabel?: string
    }
    
    const props = withDefaults(defineProps<Props>(), {
        showBusinessToggle: false,
        submitLabel: 'Enviar solicitud'
    })
    
    const emit = defineEmits<{
        submit: [payload: any]
    }>()
    
    const form = ref({
        branch: '',
        name: '',
        surname: '',
        surname2: '',
        email: '',
        phone: '',
        location: '',
        ownBusiness: 'Sí'
    })
    
    function onSubmit() {
        emit('submit', form.value)
    }
</script>
    
<template>
    <form @submit.prevent="onSubmit" class="space-y-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Elige tu sucursal</label>
            <select 
                v-model="form.branch"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
            >
                <option value="" disabled>Selecciona una sucursal</option>
                <option v-for="branch in branches" :key="branch.id" :value="branch.name">
                {{ branch.name }}
                </option>
            </select>
        </div>
    
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre(s)</label>
            <input 
                v-model="form.name"
                type="text" 
                placeholder="Escribe tu nombre"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                required
            />
        </div>
    
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">1° Apellido</label>
                <input 
                v-model="form.surname"
                type="text" 
                placeholder="Escribe aquí"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">2° Apellido</label>
                <input 
                v-model="form.surname2"
                type="text" 
                placeholder="Escribe aquí"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                />
            </div>
        </div>
    
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Correo electrónico</label>
            <input 
                v-model="form.email"
                type="email" 
                placeholder="ejemplo@gmail.com"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                required
            />
        </div>
    
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
            <input 
                v-model="form.phone"
                type="tel" 
                placeholder="Escribe aquí"
                pattern="[0-9]{10}"
                maxlength="10"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                required
            />
        </div>
    
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Dirección</label>
            <input 
                v-model="form.location"
                type="text" 
                placeholder="Escribe aquí"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
            />
        </div>
    
        <div v-if="showBusinessToggle" class="pt-4">
            <div class="text-sm font-semibold text-gray-700 mb-4">¿Tienes Negocio Físico?</div>
            <div class="flex gap-6">
                <label class="flex items-center">
                <input 
                    v-model="form.ownBusiness" 
                    type="radio" 
                    value="Sí" 
                    class="mr-2 text-blue-600 focus:ring-blue-500"
                />
                Sí
                </label>
                <label class="flex items-center">
                <input 
                    v-model="form.ownBusiness" 
                    type="radio" 
                    value="No" 
                    class="mr-2 text-blue-600 focus:ring-blue-500"
                />
                No
                </label>
            </div>
        </div>
    
        <button type="submit" class="w-full py-4 bg-gradient-to-r 
        from-green-400 to-blue-500 text-white font-bold 
        rounded-2xl hover:opacity-90 transition-opacity">
            {{ submitLabel }}
        </button>
    </form>
</template>