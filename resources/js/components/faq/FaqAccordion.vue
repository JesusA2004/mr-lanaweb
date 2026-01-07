<script setup lang="ts">
    import { ref } from 'vue'
    import type { FaqItem } from '@/data/faqs'
    
    const props = defineProps<{ items: FaqItem[] }>()
    const openId = ref<string | null>(props.items[0]?.id ?? null)
    
    function toggle(id: string) {
      openId.value = openId.value === id ? null : id
    }
    </script>
    
    <template>
      <div class="grid gap-4 lg:grid-cols-2">
        <div v-for="item in items" :key="item.id" class="rounded-3xl border border-slate-200 bg-white p-6">
          <button
            type="button"
            class="w-full text-left"
            @click="toggle(item.id)"
          >
            <div class="flex items-start justify-between gap-4">
              <div>
                <p v-if="item.category" class="text-xs font-semibold text-[#106A59]">
                  {{ item.category }}
                </p>
                <p class="mt-1 text-base font-bold text-slate-900">
                  {{ item.q }}
                </p>
              </div>
              <span class="mt-1 text-slate-600">
                {{ openId === item.id ? '−' : '+' }}
              </span>
            </div>
          </button>
    
          <div v-if="openId === item.id" class="mt-4 text-sm text-slate-700 leading-relaxed">
            {{ item.a }}
          </div>
        </div>
      </div>
    </template>
    