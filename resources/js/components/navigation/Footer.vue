<script setup lang="ts">
    import SocialLinks from '@/components/navigation/SocialLinks.vue'
    
    const year = new Date().getFullYear()
    
    const legalLinks = [
        { label: 'Términos y condiciones', href: '/terminos-y-condiciones' },
        { label: 'Aviso de privacidad', href: '/aviso-de-privacidad' },
        { label: "Preguntas Frecuentes (FAQ's)", href: '/faqs' },
    ]
    
    // Helpers (tú ya los traías)
    const link =
        'group inline-flex items-center gap-2 font-semibold text-slate-900 ' +
        'transition hover:text-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/40'
    
    const underline =
        'relative after:absolute after:-bottom-0.5 after:left-0 after:h-[2px] after:w-0 ' +
        'after:bg-gradient-to-r after:from-emerald-500 after:to-teal-400 ' +
        'after:transition-all after:duration-300 group-hover:after:w-full'
</script>
    
<template>
    <footer class="relative overflow-hidden bg-[#d9d9d9] text-slate-900">
        <!-- MOBILE / MEDIO -->
        <div class="lg:hidden md:block xl:hidden 2xl:hidden">
            <!-- BG con logo: ancho real + altura automática -->
            <div class="relative overflow-hidden">
                <img src="/img/footer/mobile-footer.webp"
                class="block w-full h-auto max-w-none" loading="lazy"/>
            </div>
        
            <div class="relative mx-auto max-w-7xl px-5 pt-5 pb-12">
                <div class="grid grid-cols-2 gap-5">
                    <!-- Contacto -->
                    <section class="min-w-0">
                        <p class="text-sm font-bold">Contáctanos</p>
            
                        <p class="mt-3 text-sm font-semibold text-slate-800">Atención al cliente</p>
                        <a href="tel:7774225973"
                        class="mt-1 inline-flex items-center gap-2 text-sm font-semibold 
                        text-emerald-700 transition hover:text-emerald-800">
                            <img src="/img/icons/icon-phone.png"
                            class="h-4 w-4 opacity-90" loading="lazy"/>
                            <span>(777) 422-5973</span>
                        </a>
            
                        <p class="mt-4 text-sm font-semibold text-slate-800">Correo</p>
                        <a href="mailto:atencionclientes@mr-lana.com"
                        class="mt-1 inline-flex text-sm font-semibold text-slate-900 
                        underline decoration-transparent underline-offset-4 transition 
                        hover:text-teal-700 hover:decoration-teal-500">
                            atencionclientes@mr-lana.com
                        </a>
            
                        <p class="mt-4 text-sm font-semibold text-slate-800">Servicio al cliente</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">
                            LUN–SAB: 10:00am a 8:00pm
                        </p>
                    </section>
            
                    <!-- Redes + legales -->
                    <section class="min-w-0">
                        <div class="mt-3">
                            <SocialLinks />
                        </div>
            
                        <div class="mt-5 space-y-2 text-sm">
                            <!-- Dejo tu br tal cual -->
                            <div v-for="l in legalLinks" :key="l.href">
                                <a :href="l.href" :class="link" class="block w-fit">
                                    <span :class="underline">{{ l.label }}</span>
                                </a>
                                <br />
                            </div>
                        </div>
                    </section>
                </div>
        
                <!-- Copy MOBILE: sí se queda -->
                <div class="mt-5 border-t border-black/10 pt-3 text-center text-xs font-medium text-slate-700">
                © {{ year }} Mr. Lana. Todos los derechos reservados.
                </div>
        
                <!-- Ovejita móvil -->
                <div class="pointer-events-none absolute bottom-2 right-2">
                    <div class="relative w-[92px] opacity-95">
                        <img src="/img/footer/bg-whaticket-mobile.png"
                        class="w-full drop-shadow-sm" loading="lazy"/>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <slot name="whaticket-mobile" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!--  DESKTOP (LG+) -->
        <div class="hidden lg:block">
            <!-- BG degree (MISMO porcentaje) -->
            <div class="absolute inset-y-0 left-0 w-[60%] xl:w-[50%] 2xl:w-[55%]">
                <img src="/img/footer/footer-degree.png"
                class="h-full w-full object-contain object-left bg-[#d9d9d9] select-none"
                loading="lazy"/>
        
                <!-- ZONA SEGURA: más fuerte en LG (para 1053px), menos en XL/2XL -->
                <div class="pointer-events-none absolute inset-y-0 right-0
                w-40 xl:w-32 2xl:w-28 bg-gradient-to-r from-transparent to-[#d9d9d9]"/>
                <!-- Scrim extra (LG only): suaviza aún más el borde cuando hay poco ancho -->
                <div class="pointer-events-none absolute inset-y-0 
                right-0 w-56 xl:w-0 bg-gradient-to-r from-transparent 
                via-[#d9d9d9]/70 to-[#d9d9d9]"/>
            </div>
        
            <!-- Contenido (MISMO padding-left por porcentaje) -->
            <div class="relative z-10 mx-auto max-w-7xl px-8 py-9 lg:pl-[46%] xl:pl-[42%] 2xl:pl-[39%]">
                <!-- Distribución -->
                <div class="grid grid-cols-12 gap-10 xl:gap-12 2xl:gap-14">
                    <!-- Contacto -->
                    <section class="col-span-6 min-w-0">
                        <p class="text-[11px] font-extrabold tracking-[0.18em] 
                        text-slate-600 xl:text-xs">
                            MR-LANA
                        </p>
            
                        <!-- LG más chico para que quepa; XL/2XL más grande -->
                        <h3 class="mt-2 font-black tracking-tight text-slate-950
                        text-[20px] lg:text-[20px] xl:text-[28px] 2xl:text-[34px]">
                            Contáctanos
                        </h3>
            
                        <!-- LG compacto para evitar choque; XL/2XL más cómodo -->
                        <div class="mt-5 space-y-3 leading-relaxed
                        text-[12px] lg:text-[12px] xl:text-[15px] 2xl:text-[16px]">
                            <div>
                                <p class="font-semibold text-slate-800">Atención al cliente</p>
                                <a href="tel:7774225973" class="group mt-2 inline-flex 
                                items-center gap-2 font-semibold text-emerald-700 
                                transition hover:text-emerald-800">
                                    <img src="/img/icons/icon-phone.png" 
                                    class="h-4 w-4 opacity-90" loading="lazy"/>
                                    <span>(777) 422-5973</span>
                                    <span class="translate-x-0 transition group-hover:translate-x-0.5">→</span>
                                </a>
                            </div>
                
                            <div>
                                <p class="font-semibold text-slate-800">Servicio al cliente</p>
                                <p class="mt-1 font-semibold text-slate-900">
                                    LUN–SAB: 10:00am a 8:00pm
                                </p>
                            </div>
                
                            <div>
                                <p class="font-semibold text-slate-800">Correo</p>
                                <a href="mailto:atencionclientes@mr-lana.com"
                                class="mt-2 inline-flex font-semibold text-slate-900 
                                underline decoration-transparent underline-offset-4 transition hover:text-teal-700 hover:decoration-teal-500 break-words">
                                    atencionclientes@mr-lana.com
                                </a>
                            </div>
                        </div>
                    </section>
            
                    <!-- Redes + legales -->
                    <section class="col-span-6 min-w-0">
                        <p class="font-black text-slate-950 text-[16px] lg:text-[16px] xl:text-[20px] 2xl:text-[22px]">
                            Síguenos en:
                        </p>
            
                        <div class="mt-4">
                            <SocialLinks />
                        </div>
            
                        <div class="mt-5 space-y-3 text-[12px] lg:text-[12px] xl:text-[15px] 2xl:text-[16px]">
                            <a v-for="l in legalLinks" :key="l.href"
                            :href="l.href" :class="link" class="block w-fit">
                                <span :class="underline">{{ l.label }}</span>
                                <span class="opacity-60 transition group-hover:opacity-100">↗</span>
                            </a>
                        </div>
                    </section>
            
                    <!-- Ovejita: NO mini; escala y NO empuja el layout -->
                    <aside class="col-span-12 flex justify-end pt-2">
                        <div class="relative w-[260px] xl:w-[320px] 2xl:w-[360px]">
                            <img src="/img/footer/bg-whabutton.png"
                            class="w-full drop-shadow-sm" loading="lazy"/>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <slot name="whaticket" />
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </footer>
</template>
