<script setup lang="ts">
    import { onMounted, ref } from 'vue'
    
    const open = ref(false)
    
    onMounted(() => {
      const dismissed = localStorage.getItem('mr_products_modal_dismissed')
      if (!dismissed) open.value = true
    })
    
    function close() {
      open.value = false
      localStorage.setItem('mr_products_modal_dismissed', '1')
    }
    </script>
    
    <template>
      <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="close"></div>
    
        <div class="relative w-full max-w-lg rounded-3xl bg-white p-6 shadow-xl">
          <div class="flex items-start justify-between gap-4">
            <div>
              <p class="inline-flex rounded-full bg-[#C2F6EC] px-3 py-1 text-xs font-semibold text-[#106A59]">
                Promoción
              </p>
              <h3 class="mt-3 text-xl font-bold text-slate-900">Productos y beneficios</h3>
              <p class="mt-2 text-sm text-slate-600">
                Conoce opciones diseñadas para tu operación diaria.
              </p>
            </div>
    
            <button type="button" class="rounded-xl border px-3 py-2 hover:bg-slate-50" @click="close">✕</button>
          </div>
    
          <div class="mt-6 flex flex-col sm:flex-row gap-3">
            <a href="/impulsa-tu-negocio" class="flex-1 rounded-2xl bg-[#1DC1A2] px-5 py-3 text-center text-sm font-semibold text-white hover:bg-[#106A59]">
              Ver opciones
            </a>
            <a href="/sucursales" class="flex-1 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-900 hover:bg-slate-50">
              Ver sucursales
            </a>
          </div>
        </div>
      </div>
    </template>
    