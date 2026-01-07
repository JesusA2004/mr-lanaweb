<script setup lang="ts">
    export type TocItem = { id: string; label: string }
    
    defineProps<{ items: TocItem[] }>()
    </script>
    
    <template>
      <aside class="sticky top-24 hidden lg:block">
        <div class="rounded-3xl border border-slate-200 bg-white p-6">
          <p class="text-sm font-bold text-slate-900">Contenido</p>
          <nav class="mt-4 flex flex-col gap-2 text-sm">
            <a
              v-for="it in items"
              :key="it.id"
              :href="`#${it.id}`"
              class="text-slate-700 hover:text-[#1DC1A2]"
            >
              {{ it.label }}
            </a>
          </nav>
        </div>
      </aside>
    </template>
    