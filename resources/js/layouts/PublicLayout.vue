<script setup lang="ts">
    import { ref, onMounted, onUnmounted } from 'vue'
    import Navbar from '@/components/navigation/Navbar.vue'
    import Footer from '@/components/navigation/Footer.vue'
    import VacanciesHub from '@/components/vacancies/VacanciesHub.vue'
    import WhaticketWidget from '@/components/integrations/WhaticketWidget.vue'
    import WhaticketBuddy from '@/components/integrations/WhaticketBuddy.vue'

    defineProps<{ title?: string }>()

    const vacanciesOpen = ref(false)

    function openVacancies() {
        vacanciesOpen.value = true
    }
    function closeVacancies() {
        vacanciesOpen.value = false
    }

    // Escuchar eventos del navbar
    function handleNavbarOpenVacancies() {
        openVacancies()
    }

    // Escuchar eventos globales desde ImpulsaNegocio
    function handleGlobalOpenVacancies() {
        openVacancies()
    }

    onMounted(() => {
        // Escuchar eventos globales
        window.addEventListener('open-vacancies-global', handleGlobalOpenVacancies)
    })

    onUnmounted(() => {
        window.removeEventListener('open-vacancies-global', handleGlobalOpenVacancies)
    })
</script>

<template>
    <div class="min-h-screen bg-white text-slate-900">

        <!-- 1) Ovejita flotante que sigue al botón
        <WhaticketBuddy
            side="right"
            :edge="18"
            :width-desktop="190"
            :width-mobile="92"
            :anchor-x-desktop="72"
            :anchor-y-desktop="62"
            :anchor-x-mobile="50"
            :anchor-y-mobile="62"
        />
        -->

        <!-- 2) Widget (crea el botón) -->
        <WhaticketWidget />

        <Navbar @openVacancies="openVacancies" />

        <!-- Bolsa de trabajo (modal global) -->
        <VacanciesHub v-model="vacanciesOpen" @close="closeVacancies" />

        <main class="w-full">
            <slot />
        </main>

        <Footer />
    </div>
</template>
