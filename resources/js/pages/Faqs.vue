<script setup lang="ts">
    import { Head } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import FaqAccordion from '@/components/faq/FaqAccordion.vue'
    import { faqs } from '@/data/faqs'
    import { ref } from 'vue'
    import { swalOk, swalErr, swalLoading, swalClose } from '@/lib/swal'

    const faqNombre = ref('')
    const faqEmail = ref('')
    const faqPregunta = ref('')
    const sendingFaq = ref(false)

    async function submitFaq() {
        if (sendingFaq.value) return
        const nombre = faqNombre.value.trim()
        const email = faqEmail.value.trim()
        const pregunta = faqPregunta.value.trim()
        if (!nombre || !email || !pregunta) {
            await swalErr('Completa nombre, correo y tu pregunta.')
            return
        }
        const csrf = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || ''
        sendingFaq.value = true
        swalLoading('Enviando pregunta...')
        try {
            const res = await fetch('/faqs/preguntar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf,
                Accept: 'application/json',
            },
            body: JSON.stringify({ nombre, email, pregunta }),
            })
            if (res.ok) {
            swalClose()
            await swalOk('Listo. Recibimos tu pregunta y te respondemos pronto.')
            faqNombre.value = ''
            faqEmail.value = ''
            faqPregunta.value = ''
            return
            }
            const err = await res.json().catch(() => ({}))
            const msg =
            err?.message ||
            (err?.errors ? (Object.values(err.errors).flat() as any[]).join(' ') : '') ||
            'No se pudo enviar. Intenta de nuevo.'
            swalClose()
            await swalErr(msg)
        } catch {
            swalClose()
            await swalErr('Sin conexión o servidor no disponible. Intenta en un momento.')
        } finally {
            sendingFaq.value = false
        }
    }
</script>

<template>
    <Head title="FAQs" />

    <PublicLayout>
        <section class="relative overflow-hidden pt-20 sm:pt-24 md:pt-28 pb-10 sm:pb-14 md:pb-20 lg:pb-24">
            <!-- Fondo base -->
            <div class="absolute inset-0 bg-slate-50 dark:bg-slate-950"></div>

            <!-- Nota: va encima del fondo, y debajo del contenido. Se desvanece hacia abajo. -->
            <div class="pointer-events-none absolute inset-x-0
            top-0 z-10 h-16 sm:h-20 md:h-24
            bg-gradient-to-b from-slate-950/75 via-slate-950/40
            to-transparent dark:from-black/65 dark:via-black/35"/>

            <!-- Blobs decorativos -->
            <div class="pointer-events-none absolute -top-28 -left-28 h-[26rem] w-[26rem] rounded-full bg-sky-200/60 dark:bg-sky-500/15" />
            <div class="pointer-events-none absolute -bottom-32 -right-32 h-[30rem] w-[30rem] rounded-full bg-indigo-200/60 dark:bg-indigo-500/15" />

            <!-- Capa de luz (ojo: más suave arriba para NO matar el top strip) -->
            <div class="pointer-events-none absolute inset-0 z-0
            bg-gradient-to-b from-white/40 via-transparent to-white/60"/>

            <!-- Contenido -->
            <div class="relative z-20 px-4 sm:px-6 lg:px-10">
                <!-- Header (SEO limpio) -->
                <header class="pt-4 sm:pt-6 md:pt-8">
                    <h1 class="text-center text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        Preguntas frecuentes (FAQ)
                    </h1>
                    <div class="mt-3 flex items-center justify-center gap-3">
                        <span class="h-px w-10 bg-slate-200 dark:bg-white/10" />
                        <span class="h-1 w-10 rounded-full bg-orange-500/90" />
                        <span class="h-px w-10 bg-slate-200 dark:bg-white/10" />
                    </div>
                    <p class="mx-auto mt-4 max-w-3xl text-center text-sm sm:text-base text-slate-600 dark:text-white/70">
                        Encuentra respuestas rápidas. Si algo no cuadra, levanta tu pregunta y lo resolvemos.
                    </p>
                </header>

                <!-- Main -->
                <main class="mx-auto mt-8 md:mt-10 max-w-7xl
                grid gap-6 sm:gap-7 lg:grid-cols-12 lg:gap-8">
                    <!-- FAQ -->
                    <section class="min-w-0 lg:col-span-7 xl:col-span-8">
                        <FaqAccordion :items="faqs" />
                    </section>
                    <!-- Form -->
                    <aside class="min-w-0 lg:col-span-5 xl:col-span-4">
                        <div class="rounded-2xl border border-slate-200/70 bg-white/80 p-5 sm:p-6
                        shadow-[0_18px_55px_-40px_rgba(0,0,0,0.45)]
                        backdrop-blur-sm">
                            <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white">
                                Haz tu pregunta
                            </h2>
                            <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-white/70">
                                Déjanos tus datos y una descripción corta. El equipo te responde.
                            </p>
                            <form class="mt-5 space-y-3" @submit.prevent="submitFaq">
                                <div>
                                    <label class="sr-only" for="faq_name">Nombre</label>
                                    <input id="faq_name" v-model="faqNombre" type="text" placeholder="Nombre"
                                    class="h-11 w-full rounded-xl border border-slate-200 bg-white px-4
                                    text-sm text-slate-900 placeholder:text-slate-400 shadow-sm
                                    outline-none focus:border-orange-400 focus:ring-2
                                    focus:ring-orange-200"/>
                                </div>

                                <div>
                                    <label class="sr-only" for="faq_email">Correo</label>
                                    <input id="faq_email" v-model="faqEmail" type="email"
                                    placeholder="Correo electrónico"  class="h-11 w-full rounded-xl border
                                    border-slate-200 bg-white px-4 text-sm text-slate-900
                                    placeholder:text-slate-400 shadow-sm outline-none
                                    focus:border-orange-400 focus:ring-2 focus:ring-orange-200"/>
                                </div>

                                <div>
                                    <label class="sr-only" for="faq_msg">Pregunta</label>
                                    <textarea id="faq_msg" v-model="faqPregunta" rows="4"
                                    placeholder="Escribe tu pregunta" class="w-full resize-none rounded-xl
                                    border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900
                                    placeholder:text-slate-400 shadow-sm outline-none
                                    focus:border-orange-400 focus:ring-2 focus:ring-orange-200"/>
                                </div>

                                <button type="submit" :disabled="sendingFaq"
                                class="inline-flex h-11 w-fit items-center justify-center rounded-xl
                                bg-orange-600 px-5 text-xs font-extrabold tracking-wide text-white
                                shadow-sm transition hover:bg-orange-500 active:translate-y-[1px]
                                focus:outline-none focus:ring-2 focus:ring-orange-300 focus:ring-offset-2">
                                    Enviar pregunta
                                </button>
                            </form>
                        </div>
                    </aside>
                </main>
            </div>
        </section>
    </PublicLayout>
</template>
