<script setup lang="ts">
    const steps = [
        {
            title: '1. Documentación',
            subtitle: 'Entregar al gestor de crédito tus documentos',
            icon: '/img/icons/icon-doc.png',
            alt: 'documentos'
        },
        {
            title: '2. Formato',
            subtitle: 'Llena los formatos de crédito Mr. lana.',
            icon: '/img/icons/icon-pencil.png',
            alt: 'lapiz'
        },
        {
            title: '3. Acepta la propuesta',
            subtitle: 'Grabamos un pequeño video solicitando tu crédito, donde se aprecia tu negocio.',
            icon: '/img/icons/icon-video.png',
            alt: 'video'
        },
        {
            title: '4. Evaluación de tu video.',
            subtitle: 'En 15 minutos te notificamos si tu crédito ha sido autorizado o rechazado.',
            icon: '/img/icons/icon-time.png',
            alt: 'tiempo'
        },
        {
            title: '5. Gestor de crédito',
            subtitle: 'Realizaremos una grabación de desembolso de crédito.',
            icon: '/img/icons/icon-money.png',
            alt: 'dinero'
        },
        {
            title: '6. Recibe tu dinero.',
            subtitle: 'Disfruta e invierte tu crédito y haz crecer tu negocio.',
            icon: '/img/icons/icon-invest.png',
            alt: 'inversión'
        }
    ]
</script>
    
<template>
    <div class="bg-gray-800 py-12">
        <Container>
            <h2 class="text-center text-3xl font-bold text-white mb-12">PASOS PARA OBTENER TU CRÉDITO</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                v-for="step in steps"
                :key="step.title"
                class="bg-white rounded-2xl p-6 flex flex-col items-center text-center"
                >
                <img :src="step.icon" :alt="step.alt" class="w-20 h-20 mb-4" />
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ step.title }}</h3>
                <p class="text-gray-600">{{ step.subtitle }}</p>
                </div>
            </div>
        </Container>
    </div>
</template>