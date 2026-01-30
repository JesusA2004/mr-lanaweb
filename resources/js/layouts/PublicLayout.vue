<script setup lang="ts">
    import { ref, onMounted, onUnmounted } from 'vue'
    import Swal from 'sweetalert2'
    import Navbar from '@/components/navigation/Navbar.vue'
    import Footer from '@/components/navigation/Footer.vue'
    import VacanciesHub from '@/components/vacancies/VacanciesHub.vue'
    import WhaticketWidget from '@/components/integrations/WhaticketWidget.vue'

    const SWAL_KEY = '__active_swal__'

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

        const raw = sessionStorage.getItem(SWAL_KEY)
        if (!raw) return

        const data = JSON.parse(raw)

        Swal.fire({
            icon: data.variant,
            title: data.title,
            text: data.text || '',
            confirmButtonText: 'OK',
            showCloseButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            heightAuto: false,
        }).then(() => {
            sessionStorage.removeItem(SWAL_KEY)
        })
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
