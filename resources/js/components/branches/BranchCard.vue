<script setup lang="ts">
    import type { Branch } from '@/data/sucursales'
    
    defineProps<{ branch: Branch }>()
    </script>
    
    <template>
      <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition">
        <h3 class="text-lg font-bold text-slate-900">{{ branch.name }}</h3>
        <p class="mt-1 text-sm text-slate-600">{{ branch.city }}, {{ branch.state }}</p>
    
        <p class="mt-4 text-sm text-slate-700">
          {{ branch.address }}
        </p>
    
        <div v-if="branch.phones?.length" class="mt-4 space-y-1 text-sm text-slate-700">
          <p v-for="p in branch.phones" :key="p">Tel: {{ p }}</p>
        </div>
    
        <div class="mt-6 flex flex-wrap gap-3">
          <a
            v-if="branch.mapUrl"
            :href="branch.mapUrl"
            target="_blank"
            rel="noopener noreferrer"
            class="rounded-2xl bg-[#1DC1A2] px-5 py-3 text-sm font-semibold text-white hover:bg-[#106A59] transition"
          >
            Ver en Google Maps
          </a>
    
          <a
            href="#solicitar"
            class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50 transition"
          >
            Solicitar
          </a>
        </div>
      </article>
    </template>
    