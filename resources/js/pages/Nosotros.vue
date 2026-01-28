<script setup lang="ts">
    import { Head, Link } from '@inertiajs/vue3'
    import PublicLayout from '@/layouts/PublicLayout.vue'
    import Container from '@/components/ui/Container.vue'

    const title = '¿Quiénes somos?'
    // ====== RUTAS (ya con tus nombres reales) ======
    const IMG = {
        // textos como imagen
        quienesSomosTxt: '/img/nosotros/quienesSomos.png',
        principiosTxt: '/img/nosotros/principios.png',
        // logo
        logo: '/img/nosotros/logo-mr-lana.png',
        // bordes/ondas
        bordeArriba: '/img/nosotros/bordeArriba.png',
        bordeAbajo: '/img/nosotros/bordeAbajo.png',
        // círculos: con texto / sin texto
        innovacionCon: '/img/nosotros/innovacionConTexto.png',
        innovacionSin: '/img/nosotros/innovacionSinTexto.png',
        diligenciaCon: '/img/nosotros/diligenciaConTexto.png',
        diligenciaSin: '/img/nosotros/diligenciaSinTexto.png',
        integridadCon: '/img/nosotros/integridadConTexto.png',
        integridadSin: '/img/nosotros/integridadSinTexto.png',
        trabajoCon: '/img/nosotros/trabajoConTexto.png',
        trabajoSin: '/img/nosotros/trabajoSinTexto.png',
        // ovejas
        ovejaPrimera: '/img/nosotros/ovejaPrimera.png',
        ovejaSegunda: '/img/nosotros/ovejaSegunda.png',
        // misión / visión (texto en imagen)
        mision: '/img/nosotros/mision.png',
        vision: '/img/nosotros/vision.png',
    } as const
</script>

<template>
    <Head :title="title" />

    <PublicLayout>
        <!-- HOJA 1 (BG neutral): QUIÉNES SOMOS + PRINCIPIOS -->
        <section class="relative overflow-hidden bg-zinc-950 pt-5 sm:pt-5 md:pt-15 lg:pt-20 pb-14 sm:pb-16 md:pb-20">
            <!-- patrón punteado -->
            <div class="pointer-events-none absolute inset-0 opacity-25"
            style=" background-image: radial-gradient(rgba(255,255,255,.22) 1px, transparent 1px);
            background-size: 18px 18px;"/>
            <!-- blobs -->
            <div class="pointer-events-none absolute -top-44 -left-44 h-[36rem] w-[36rem] rounded-full bg-emerald-500/14 blur-3xl" />
            <div class="pointer-events-none absolute -bottom-52 -right-52 h-[40rem] w-[40rem] rounded-full bg-sky-500/14 blur-3xl" />

            <Container>
                <div class="relative overflow-hidden rounded-[34px] border border-white/10 bg-white/[0.06]
                shadow-[0_35px_90px_-55px_rgba(0,0,0,.95)] backdrop-blur-md">
                    <!-- LOGO -->
                    <div class="px-5 sm:px-8 md:px-10 pt-8 sm:pt-10 md:pt-12">
                        <div class="flex items-center justify-center">
                            <img :src="IMG.logo" alt="Mr Lana" class="h-14 sm:h-16 md:h-18 2xl:h-40
                            drop-shadow-[0_10px_25px_rgba(0,0,0,.55)] transition duration-300 hover:scale-[1.02]"
                            loading="lazy" />
                        </div>

                        <!-- QUIÉNES SOMOS (texto como imagen) -->
                        <div class="mt-6 flex justify-center">
                            <img :src="IMG.quienesSomosTxt" alt="¿Quiénes somos?"
                            class="h-10 sm:h-12 md:h-14 lg:h-16 2xl:h-50 drop-shadow-[0_18px_40px_rgba(0,0,0,.6)]
                            transition duration-300 hover:scale-[1.01]" loading="lazy"/>
                        </div>

                        <!-- PÁRRAFO-->
                        <p class="mx-auto mt-5 max-w-6xl text-center text-sm sm:text-base md:text-lg 2xl:text-3xl
                        text-white/85 leading-relaxed">
                        Mr. Lana es una entidad financiera mexicana de nano y microcréditos que trabaja con compromiso y pasión para ofrecer préstamos rápidos
                        a negocios, con el fin de impulsar el crecimiento y desarrollo de proyectos productivos en el país.
                        </p>
                    </div>

                    <!-- PRINCIPIOS -->
                    <div class="px-5 sm:px-8 md:px-10 pb-10 sm:pb-12 md:pb-14 pt-10 sm:pt-12">
                        <!-- PRINCIPIOS (texto como imagen) -->
                        <div class="flex justify-center">
                            <img :src="IMG.principiosTxt" alt="Principios"
                            class="h-10 sm:h-12 md:h-14 lg:h-16 2xl:h-40  drop-shadow-[0_18px_40px_rgba(0,0,0,.6)]
                            transition duration-300 hover:scale-[1.01]" loading="lazy"/>
                        </div>

                        <!-- composición centrada y responsive -->
                        <div class="relative mx-auto mt-10 max-w-6xl">
                            <!-- MOBILE/TABLET: stack (2 arriba + oveja + 2 abajo) -->
                            <div class="grid gap-6 sm:gap-7 lg:hidden">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-7">
                                    <!-- Innovación (arriba izquierda) -->
                                    <div class="group flex justify-center">
                                        <div class="relative w-full max-w-[340px] aspect-square rounded-full
                                        shadow-[0_30px_80px_-60px_rgba(0,0,0,.95)]
                                        transition duration-300 hover:-translate-y-1 hover:scale-[1.01]">
                                            <img :src="IMG.innovacionCon" class="h-full w-full object-contain"
                                            loading="lazy"/>
                                            <div class="pointer-events-none absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
                                                <div class="absolute inset-0 rounded-full bg-gradient-to-b from-emerald-400/10 to-transparent" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Diligencia (en tu diseño va arriba derecha) -->
                                    <div class="group flex justify-center">
                                        <div  class="relative w-full max-w-[340px] aspect-square rounded-full
                                        shadow-[0_30px_80px_-60px_rgba(0,0,0,.95)] transition duration-300 hover:-translate-y-1 hover:scale-[1.01]">
                                            <!-- en responsive: SIN TEXTO -->
                                            <img :src="IMG.diligenciaCon" class="h-full w-full object-contain"
                                            loading="lazy"/>
                                            <!-- halo -->
                                            <div class="pointer-events-none absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
                                                <div class="absolute inset-0 rounded-full bg-gradient-to-b from-emerald-400/10 to-transparent" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Oveja centrada -->
                                <div class="flex items-center justify-center">
                                    <img :src="IMG.ovejaPrimera" class="h-36 sm:h-44 md:h-52 w-auto
                                    drop-shadow-[0_25px_55px_rgba(0,0,0,.65)] transition duration-300 hover:scale-[1.03]"
                                    loading="lazy"/>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-7">
                                    <!-- Trabajo en equipo (abajo izq) -->
                                    <div class="group flex justify-center">
                                        <div class="relative w-full max-w-[340px] aspect-square rounded-full
                                        shadow-[0_30px_80px_-60px_rgba(0,0,0,.95)]
                                        transition duration-300 hover:-translate-y-1 hover:scale-[1.01]">
                                            <img :src="IMG.trabajoCon" class="h-full w-full object-contain"
                                            loading="lazy"/>
                                            <div class="pointer-events-none absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
                                                <div class="absolute inset-0 rounded-full bg-gradient-to-b from-sky-300/10 to-transparent" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Integridad (abajo der) -->
                                    <div class="group flex justify-center">
                                        <div class="relative w-full max-w-[340px] aspect-square rounded-full
                                        shadow-[0_30px_80px_-60px_rgba(0,0,0,.95)] transition duration-300 hover:-translate-y-1 hover:scale-[1.01]">
                                            <img :src="IMG.integridadCon"
                                            class="h-full w-full object-contain" loading="lazy"/>
                                            <div class="pointer-events-none absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
                                                <div class="absolute inset-0 rounded-full bg-gradient-to-b from-teal-300/10 to-transparent" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DESKTOP (lg+): 4 círculos + oveja al centro, usando CON TEXTO -->
                            <div class="hidden lg:block">
                                <div class="relative mx-auto min-h-[560px] xl:min-h-[650px] 2xl:min-h-[670px] max-w-6xl py-6">
                                    <!-- oveja centro -->
                                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                                        <img :src="IMG.ovejaPrimera"  class="h-52 xl:h-60 2xl:h-64 w-auto
                                        drop-shadow-[0_30px_70px_rgba(0,0,0,.65)] transition duration-300 hover:scale-[1.03]"
                                        loading="lazy"/>
                                    </div>

                                    <!-- TR: Innovación -->
                                    <div class="absolute left-0 top-0 group">
                                        <div class="relative h-[260px] w-[260px] xl:h-[285px] xl:w-[285px] 2xl:h-[305px] 2xl:w-[305px]
                                        rounded-full shadow-[0_35px_90px_-60px_rgba(0,0,0,.95)] transition duration-300 hover:-translate-y-1 hover:scale-[1.01]">
                                            <img :src="IMG.innovacionCon" alt="Innovación" class="h-full w-full object-contain" loading="lazy" />
                                            <div class="pointer-events-none absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
                                                <div class="absolute inset-0 rounded-full bg-gradient-to-b from-lime-400/10 to-transparent" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TL: Diligencia -->
                                    <div class="absolute right-0 top-0 group">
                                        <div class="relative h-[260px] w-[260px] xl:h-[285px] xl:w-[285px] 2xl:h-[305px] 2xl:w-[305px]
                                        rounded-full shadow-[0_35px_90px_-60px_rgba(0,0,0,.95)] transition duration-300 hover:-translate-y-1 hover:scale-[1.01]">
                                            <img :src="IMG.diligenciaCon" alt="Diligencia" class="h-full w-full object-contain" loading="lazy" />
                                            <div class="pointer-events-none absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
                                                <div class="absolute inset-0 rounded-full bg-gradient-to-b from-emerald-400/10 to-transparent" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BL: Trabajo en equipo -->
                                    <div class="absolute left-0 bottom-0 group">
                                        <div class="relative h-[260px] w-[260px] xl:h-[285px] xl:w-[285px] 2xl:h-[305px] 2xl:w-[305px]
                                        rounded-full shadow-[0_35px_90px_-60px_rgba(0,0,0,.95)] transition duration-300 hover:-translate-y-1 hover:scale-[1.01]">
                                            <img :src="IMG.trabajoCon" alt="Trabajo en equipo" class="h-full w-full object-contain" loading="lazy" />
                                            <div class="pointer-events-none absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
                                                <div class="absolute inset-0 rounded-full bg-gradient-to-b from-sky-300/10 to-transparent" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BR: Integridad -->
                                    <div class="absolute right-0 bottom-0 group">
                                        <div class="relative h-[260px] w-[260px] xl:h-[285px] xl:w-[285px] 2xl:h-[305px] 2xl:w-[305px]
                                        rounded-full shadow-[0_35px_90px_-60px_rgba(0,0,0,.95)] transition duration-300 hover:-translate-y-1 hover:scale-[1.01]">
                                            <img :src="IMG.integridadCon" alt="Integridad" class="h-full w-full object-contain" loading="lazy" />
                                            <div class="pointer-events-none absolute inset-0 rounded-full opacity-0 group-hover:opacity-100 transition duration-300">
                                                <div class="absolute inset-0 rounded-full bg-gradient-to-b from-teal-300/10 to-transparent" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        </section>

        <!-- ===================== HOJA 2 (BG white): MISIÓN / VISIÓN ===================== -->
        <section class="relative overflow-hidden bg-white">
            <!-- patrón sutil -->
            <div class="pointer-events-none absolute inset-0 opacity-[0.06]"
            style=" background-image: radial-gradient(rgba(2, 6, 23, 0.45) 1px, transparent 1px);
            background-size: 18px 18px;"/>

            <!-- BORDE ARRIBA (100% viewport, sin blancos laterales) -->
            <div class="pointer-events-none absolute top-0 left-1/2 -translate-x-1/2 w-screen z-10">
                <img :src="IMG.bordeArriba" class="w-screen h-[140px] sm:h-[170px] md:h-[210px]
                lg:h-[250px] xl:h-[290px] 2xl:h-[340px] object-cover"loading="lazy"/>
            </div>

            <!-- LOGO (encima del borde, centrado) -->
            <div class="absolute top-6 sm:top-8 md:top-10 lg:top-12 xl:top-14 2xl:top-16 left-1/2 -translate-x-1/2 z-30">
                <img :src="IMG.logo" class="h-15 sm:h-20 md:h-25 lg:h-25 xl:h-35 2xl:h-50 w-auto
                drop-shadow-[0_10px_25px_rgba(0,0,0,.25)] transition duration-300 hover:scale-[1.02]"
                loading="lazy"/>
            </div>

            <!-- BORDE ABAJO (100% viewport, sin recorte, sin blancos laterales) -->
            <div class="pointer-events-none absolute bottom-0 left-1/2 -translate-x-1/2 w-screen z-10">
                <img :src="IMG.bordeAbajo" class="w-screen h-auto object-contain"
                    loading="lazy"/>
            </div>

            <Container>
                <!-- IMPORTANTE: dejamos espacio arriba/abajo para que los bordes NO tapen -->
                <div class="relative
                pt-[170px] sm:pt-[200px] md:pt-[240px] lg:pt-[290px] xl:pt-[330px] 2xl:pt-[380px]
                pb-[190px] sm:pb-[220px] md:pb-[260px] lg:pb-[310px] xl:pb-[350px] 2xl:pb-[400px]">
                    <!-- composición centrada + responsive -->
                    <div class="relative mx-auto mt-10 sm:mt-12 md:mt-14 lg:mt-16 max-w-6xl">
                        <!-- Oveja (encima, izquierda, responsive) -->
                        <div class="absolute left-[-5px] sm:left-[-5px] md:left-[-0px] lg:left-[-0px]
                        2xl:left-[-0px] top-[-50px] sm:top-[-70px] md:top-[-80px] lg:top-[-100px]
                        2xl:top-[-130px] z-20 pointer-events-none">
                            <img :src="IMG.ovejaSegunda" class="h-25 sm:h-40 md:h-50 lg:h-65 xl:h-70 2xl:h-85 w-auto drop-shadow-[0_18px_35px_rgba(0,0,0,.25)]"
                            loading="lazy"/>
                        </div>

                        <!-- Spacer: reserva altura para la oveja (porque es absolute y no empuja) -->
                        <div class="h-10 sm:h-20 md:h-25 lg:h-30 2xl:h-45"></div>

                        <!-- Cards -->
                        <div class="grid gap-8 sm:gap-10 md:gap-12 lg:gap-14">
                            <!-- ===== MISIÓN ===== -->
                            <div class="flex justify-center">
                                <div class="group relative w-full max-w-2xl
                                md:max-w-3xl
                                lg:max-w-3xl xl:max-w-4xl 2xl:max-w-5xl overflow-hidden rounded-[28px]
                                shadow-[0_28px_70px_-50px_rgba(0,0,0,.35)] transition duration-300 hover:-translate-y-1
                                hover:shadow-[0_40px_90px_-55px_rgba(0,0,0,.45)]">
                                    <!-- Imagen base (SIN recorte) -->
                                    <img :src="IMG.mision" alt="Misión" class="w-full h-auto object-contain" loading="lazy" />

                                    <!-- Overlay de texto centrado -->
                                    <div class="absolute inset-0 flex items-start justify-end
                                    px-35 sm:px-35 md:px-35 lg:px-30 xl:px-30 2xl:px-45
                                    pt-3 sm:pt-6 md:pt-7 lg:pt-6 xl:pt-7 2xl:pt-15
                                    pr-6 sm:pr-5 md:pr-9 lg:pr-10 xl:pr-10 2xl:pr-15">
                                        <!-- Ajuste fino: en desktop empuja un poco a la derecha por el ícono circular -->
                                        <div class="w-full max-w-5xl text-right lg:pl-10 xl:pl-14 2xl:pl-16">
                                            <h3 class="font-extrabold tracking-tight text-white
                                            text-2xl sm:text-3xl md:text-4xl lg:text-4xl xl:text-4xl 2xl:text-5xl">
                                                Misión
                                            </h3>

                                            <p class="mt-3 sm:mt-4 md:mt-5 leading-relaxed text-white/95
                                            text-xs sm:text-sm md:text-base lg:text-lg xl:text-lg 2xl:text-xl">
                                                Satisfacer las necesidades financieras de los clientes a través de
                                                <span class="font-bold text-emerald-300">préstamos rápidos</span> y
                                                <span class="font-bold text-emerald-300">confiables</span>, a negocios establecidos y personas con
                                                actividad laboral, para
                                                <span class="font-bold text-emerald-300">impulsar sus proyectos productivos</span>.
                                            </p>
                                        </div>
                                    </div>

                                    <!-- brillo sutil -->
                                    <div class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300">
                                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-400/10 via-transparent to-transparent" />
                                    </div>
                                </div>
                            </div>

                            <!-- ===== VISIÓN ===== -->
                            <div class="flex justify-center">
                                <div class="group relative w-full max-w-2xl
                                lg:max-w-3xl xl:max-w-4xl 2xl:max-w-5xl  overflow-hidden rounded-[28px]
                                shadow-[0_28px_70px_-50px_rgba(0,0,0,.35)] transition duration-300 hover:-translate-y-1
                                hover:shadow-[0_40px_90px_-55px_rgba(0,0,0,.45)]">
                                    <!-- Imagen base (SIN recorte) -->
                                    <img :src="IMG.vision" alt="Visión" class="w-full h-auto object-contain" loading="lazy" />

                                    <!-- Overlay de texto centrado -->
                                    <div class="absolute inset-0 flex items-start justify-start
                                    px-35 sm:px-45 md:px-40 lg:px-40 xl:px-50 2xl:px-60
                                    pt-3 sm:pt-6 md:pt-8 lg:pt-10 xl:pt-12 2xl:pt-14
                                    pl-8 sm:pl-8 md:pl-12 lg:pl-16 xl:pl-20 2xl:pl-24">
                                        <!-- Ajuste: en desktop empuja un poco a la izquierda por el ícono circular derecho -->
                                        <div class="w-full max-w-3xl text-left lg:pr-10 xl:pr-14 2xl:pr-16">
                                            <h3 class="font-extrabold tracking-tight text-white
                                            text-2xl sm:text-3xl md:text-4xl lg:text-4xl xl:text-4xl 2xl:text-5xl">
                                                Visión
                                            </h3>

                                            <p class="mt-3 sm:mt-4 md:mt-5 leading-relaxed text-white/95
                                            text-xs sm:text-sm md:text-base lg:text-lg xl:text-lg 2xl:text-xl">
                                                Consolidarnos y posicionarnos como la entidad financiera número uno en la rama de nano y microcréditos
                                                en el mercado nacional e internacional, a través de innovación tecnológica y desarrollo constante de
                                                nuestros colaboradores.
                                                <span class="font-bold text-sky-300">
                                                Generando confianza y fidelidad por parte de nuestros clientes
                                                </span>.
                                            </p>
                                        </div>
                                    </div>

                                    <!-- brillo sutil -->
                                    <div class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300">
                                        <div class="absolute inset-0 bg-gradient-to-l from-sky-300/10 via-transparent to-transparent" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- separador -->
                        <div class="mt-20 sm:mt-35 md:mt-65 lg:mt-80 xl:mt-95 flex items-center justify-center">
                            <span class="h-px w-28 bg-slate-200" />
                        </div>
                    </div>
                </div>
            </Container>
        </section>
    </PublicLayout>
</template>
