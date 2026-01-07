<script setup lang="ts">
    defineProps<{
      leftTitle?: string
      leftText?: string
      leftHref?: string
      rightTitle?: string
      rightText?: string
      rightHref?: string
    }>()
    </script>
    
    <template>
      <section class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="grid gap-6 md:grid-cols-2">
            <a
              :href="leftHref ?? '/impulsa-tu-negocio'"
              class="group rounded-3xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-md transition"
            >
              <p class="inline-flex rounded-full bg-[#C2F6EC] px-3 py-1 text-xs font-semibold text-[#106A59]">
                Impulsa tu negocio
              </p>
              <h3 class="mt-4 text-2xl font-bold text-slate-900">
                {{ leftTitle ?? 'Crédito diseñado para operar mejor' }}
              </h3>
              <p class="mt-2 text-slate-600">
                {{ leftText ?? 'Solicita en minutos y recibe seguimiento claro.' }}
              </p>
              <div class="mt-6 text-sm font-semibold text-[#1DC1A2] group-hover:text-[#106A59]">
                Conocer más →
              </div>
            </a>
    
            <a
              :href="rightHref ?? '/impulsat'"
              class="group rounded-3xl border border-slate-200 bg-white p-8 shadow-sm hover:shadow-md transition"
            >
              <p class="inline-flex rounded-full bg-[#C2F6EC] px-3 py-1 text-xs font-semibold text-[#106A59]">
                Impulsa.t
              </p>
              <h3 class="mt-4 text-2xl font-bold text-slate-900">
                {{ rightTitle ?? 'Financiamiento sin fricción' }}
              </h3>
              <p class="mt-2 text-slate-600">
                {{ rightText ?? 'Atención rápida, sucursal cercana y proceso transparente.' }}
              </p>
              <div class="mt-6 text-sm font-semibold text-[#1DC1A2] group-hover:text-[#106A59]">
                Conocer más →
              </div>
            </a>
          </div>
        </div>
      </section>
    </template>
    