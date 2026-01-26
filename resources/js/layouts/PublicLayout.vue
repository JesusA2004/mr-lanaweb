<script setup lang="ts">
    import { ref, onMounted, onUnmounted } from 'vue'
    import Navbar from '@/components/navigation/Navbar.vue'
    import Footer from '@/components/navigation/Footer.vue'
    import VacanciesHub from '@/components/vacancies/VacanciesHub.vue'
    import WhaticketWidget from '@/components/integrations/WhaticketWidget.vue'

    defineProps<{ title?: string }>()

    const vacanciesOpen = ref(false)

    function openVacancies() {
        vacanciesOpen.value = true
    }
    function closeVacancies() {
        vacanciesOpen.value = false
    }

    function handleGlobalOpenVacancies() {
        openVacancies()
    }

    function ensureSwalOnTop() {
        // Esto fuerza Swal encima de modales/backdrops
        if (document.getElementById('swal2-zfix')) return
        const style = document.createElement('style')
        style.id = 'swal2-zfix'
        style.textContent = `
            .swal2-container { z-index: 200000 !important; }
        `
        document.head.appendChild(style)
    }

    onMounted(() => {
        ensureSwalOnTop()
        window.addEventListener('open-vacancies-global', handleGlobalOpenVacancies)
    })

    onUnmounted(() => {
        window.removeEventListener('open-vacancies-global', handleGlobalOpenVacancies)
    })
</script>

<template>
    <div class="min-h-screen bg-white text-slate-900">
        <WhaticketWidget />

        <Navbar @openVacancies="openVacancies" />

        <VacanciesHub v-model="vacanciesOpen" @close="closeVacancies" />

        <main class="w-full">
            <slot />
        </main>

        <Footer />
    </div>
</template>
