<script setup lang="ts">
    import { computed, ref } from 'vue'
    import type { Branch } from '@/data/sucursales'
    import ZoneTabs from './ZoneTabs.vue'
    import BranchCard from './BranchCard.vue'
    import SearchInput from './SearchInput.vue'
    
    const props = defineProps<{
      branches: Branch[]
      zones: { key: string; label: string }[]
      defaultZone?: string
    }>()
    
    const zone = ref(props.defaultZone ?? props.zones?.[0]?.key ?? '')
    const q = ref('')
    
    const filtered = computed(() => {
      const term = q.value.trim().toLowerCase()
      return props.branches
        .filter((b) => (zone.value ? b.zone === zone.value : true))
        .filter((b) => {
          if (!term) return true
          const hay = `${b.name} ${b.city} ${b.state} ${b.address}`.toLowerCase()
          return hay.includes(term)
        })
    })
    </script>
    
    <template>
      <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 md:items-end">
          <div>
            <p class="text-sm font-semibold text-slate-900 mb-2">Zona</p>
            <ZoneTabs v-model="zone" :zones="zones" />
          </div>
    
          <div>
            <p class="text-sm font-semibold text-slate-900 mb-2">Buscar</p>
            <SearchInput v-model="q" placeholder="Ciudad, estado o sucursal..." />
          </div>
        </div>
    
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <BranchCard v-for="b in filtered" :key="b.id" :branch="b" />
        </div>
    
        <div v-if="filtered.length === 0" class="rounded-3xl border border-slate-200 bg-white p-10 text-center">
          <p class="font-semibold text-slate-900">Sin resultados</p>
          <p class="mt-2 text-sm text-slate-600">Intenta otra zona o ajusta tu búsqueda.</p>
        </div>
      </div>
    </template>
    