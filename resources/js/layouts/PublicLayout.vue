<script setup lang="ts">
    import { ref } from 'vue'
    import Navbar from '@/components/navigation/Navbar.vue'
    import Footer from '@/components/navigation/Footer.vue'
    import VacanciesHub from '@/components/vacancies/VacanciesHub.vue'
    
    defineProps<{ title?: string }>()
    
    const vacanciesOpen = ref(false)
    
    function openVacancies() {
        vacanciesOpen.value = true
    }
    function closeVacancies() {
        vacanciesOpen.value = false
    }
</script>
    
<template>
    <div class="min-h-screen bg-white text-slate-900">
        <Navbar @openVacancies="openVacancies" />
    
        <!-- Bolsa de trabajo (modal global) -->
        <VacanciesHub v-model="vacanciesOpen" @close="closeVacancies" />
    
        <main class="w-full">
            <slot />
        </main>
    
        <Footer />
    </div>
</template>
    