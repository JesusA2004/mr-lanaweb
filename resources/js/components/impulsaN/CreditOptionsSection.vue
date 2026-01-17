<script setup lang="ts">
    import { ref } from 'vue'
    import { credits } from '@/data/credits'
    import CreditDetailModal from '@/components/impulsaN/CreditDetailModal.vue'
    
    const selectedCredit = ref<any>(null)
    const modalOpen = ref(false)
    
    function openModal(credit: any) {
        selectedCredit.value = credit
        modalOpen.value = true
    }
    
    function closeModal() {
        modalOpen.value = false
    }
    
    const weeklyCredits = credits.filter(c => c.schedule === 'Semanal')
</script>
    
<template>
    <div class="py-20">
        <Container>
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-slate-900">CONTAMOS CON DIFERENTES OPCIONES PARA TI</h2>
                <p class="text-xl text-slate-600 mt-4">
                Conoce los créditos diarios y semanales para tu negocio, <b>fácil y rápido</b>
                </p>
            </div>
        
            <!-- Semanal -->
            <div>
                <h3 class="text-3xl font-bold text-center text-slate-900 mb-8">Semanal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    v-for="credit in weeklyCredits"
                    :key="credit.id"
                    class="bg-white rounded-3xl border border-slate-200 p-6 text-center cursor-pointer hover:shadow-lg transition-shadow"
                    @click="openModal(credit)"
                >
                    <img :src="credit.icon" :alt="credit.alt" class="w-24 h-24 mx-auto mb-4" />
                    <h4 class="text-2xl font-bold text-slate-900">{{ credit.name }}</h4>
                    <p class="text-slate-600 mt-2">Pagos: {{ credit.payments }}</p>
                    <p class="text-slate-600">{{ credit.creditRange }}</p>
                </div>
                </div>
            </div>
        </Container>
    
        <CreditDetailModal :open="modalOpen"
        :credit="selectedCredit" @close="closeModal"/>
    </div>
</template>