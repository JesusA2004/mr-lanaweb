<script setup lang="ts">
    import { ref } from 'vue'
    
    defineProps<{
        srcCreditIcon: string
        altIcon: string
        schedule: string
        payments: number
        credit: string
        modalId: string
        specs?: Record<string, string> 
    }>()
    
    const modalOpen = ref(false)
    
    function openModal() {
        modalOpen.value = true
    }
    
    function closeModal() {
        modalOpen.value = false
    }
</script>
    
<template>
    <div class="relative">
        <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-lg transition-shadow cursor-pointer"
        @click="openModal">
            <div class="flex items-center justify-between mb-4">
                <div>
                <span class="text-sm font-semibold text-gray-500">{{ schedule }}</span>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ payments }} pagos</h3>
                </div>
                <img :src="srcCreditIcon" :alt="altIcon" class="w-16 h-16" />
            </div>
            <p class="text-gray-700">{{ credit }}</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-blue-600 font-semibold">Ver detalles →</span>
            </div>
        </div>
    
        <!-- Modal -->
        <div v-if="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900">{{ schedule }} - {{ payments }} pagos</h3>
                <button 
                    @click="closeModal" 
                    class="text-gray-400 hover:text-gray-600 transition-colors"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                </div>
                <div class="p-6">
                <div class="flex items-center justify-center mb-6">
                    <img :src="srcCreditIcon" :alt="altIcon" class="w-24 h-24" />
                </div>
                <div class="space-y-3">
                    <div v-for="(value, key) in $attrs.specs || {}" :key="key" class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-semibold text-gray-700">{{ key }}:</span>
                    <span class="text-gray-900">{{ value }}</span>
                    </div>
                </div>
                <div class="mt-8 flex justify-center">
                    <button 
                    @click="closeModal"
                    class="px-6 py-3 bg-gradient-to-r from-green-400 to-blue-500 text-white font-semibold rounded-full hover:opacity-90 transition-opacity"
                    >
                    Cerrar
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>