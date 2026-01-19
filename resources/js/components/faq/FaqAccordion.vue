<!-- resources/js/components/faq/FaqAccordion.vue -->
<script setup lang="ts">
import { computed, ref } from 'vue'

interface FaqItem {
  id: number
  question: string
  answer: string | string[]
}

interface Props {
  items: FaqItem[]
}

const { items } = defineProps<Props>()
const openItem = ref<number | null>(items?.[0]?.id ?? null)

const toggleItem = (id: number) => {
  openItem.value = openItem.value === id ? null : id
}

const cleanQuestion = (q: string) => q.replace(/^\d+\.\s*/, '')

const isIntro = (s: string) => {
  const t = (s || '').trim()
  return t.startsWith('Mr. Lana') || t.startsWith('Para')
}

const normalized = computed(() =>
  (items || []).map((it) => ({
    ...it,
    q: cleanQuestion(it.question),
  }))
)
</script>

<template>
  <div class="w-full max-w-5xl mx-auto">


    <!-- Acordeón -->
    <div class="space-y-3 sm:space-y-4">
      <div
        v-for="item in normalized"
        :key="item.id"
        class="group overflow-hidden rounded-2xl border border-sky-200/15 bg-sky-500/10
               shadow-sm transition hover:bg-sky-500/15 hover:border-sky-200/25"
        :class="{ 'ring-1 ring-sky-300/30 bg-sky-500/15': openItem === item.id }"
      >
        <button
          type="button"
          @click="toggleItem(item.id)"
          class="flex w-full items-center gap-3 sm:gap-4 px-4 sm:px-5 md:px-6 py-4 sm:py-5 text-left"
        >
          <!-- Badge número -->
          <div
            class="flex h-9 w-9 sm:h-10 sm:w-10 shrink-0 items-center justify-center rounded-xl
                   border border-sky-200/20 bg-sky-500/10 text-white font-extrabold text-xs sm:text-sm"
          >
            {{ item.id }}
          </div>

          <!-- Texto -->
          <div class="min-w-0 flex-1">
            <h3
              class="truncate text-sm sm:text-[0.95rem] md:text-base lg:text-lg font-bold text-white transition
                     group-hover:text-sky-100"
            >
              {{ item.q }}
            </h3>
            <p class="mt-1 text-xs sm:text-sm text-white/70">
              Toca para ver la respuesta.
            </p>
          </div>

          <!-- Chevron -->
          <div class="shrink-0">
            <div
              class="grid h-9 w-9 sm:h-10 sm:w-10 place-items-center rounded-xl border border-sky-200/15 bg-sky-500/5 transition
                     group-hover:bg-sky-500/10"
            >
              <svg
                class="h-5 w-5 text-white/80 transition duration-200"
                :class="{ 'rotate-180 text-sky-100': openItem === item.id }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
          </div>
        </button>

        <!-- Respuesta -->
        <transition
          enter-active-class="transition duration-200 ease-out"
          leave-active-class="transition duration-150 ease-in"
          enter-from-class="opacity-0 -translate-y-1"
          enter-to-class="opacity-100 translate-y-0"
          leave-from-class="opacity-100 translate-y-0"
          leave-to-class="opacity-0 -translate-y-1"
        >
          <div v-show="openItem === item.id" class="px-4 sm:px-5 md:px-6 pb-5 sm:pb-6">
            <div class="rounded-2xl border border-sky-200/15 bg-sky-500/10 p-4 sm:p-5 md:p-6">
              <!-- string -->
              <div
                v-if="typeof item.answer === 'string'"
                class="text-sm sm:text-[0.95rem] md:text-base text-white/85 leading-relaxed"
              >
                {{ item.answer }}
              </div>

              <!-- array -->
              <div v-else class="space-y-4">
                <p
                  v-if="item.answer.length && isIntro(item.answer[0])"
                  class="text-sm sm:text-[0.95rem] md:text-base text-white/85 leading-relaxed"
                >
                  {{ item.answer[0] }}
                </p>

                <ul class="space-y-3">
                  <li
                    v-for="(line, i) in (item.answer.length && isIntro(item.answer[0]) ? item.answer.slice(1) : item.answer)"
                    :key="i"
                    class="flex items-start gap-3"
                  >
                    <span class="mt-1 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-sky-300/20">
                      <svg class="h-3.5 w-3.5 text-sky-100" fill="currentColor" viewBox="0 0 20 20">
                        <path
                          fill-rule="evenodd"
                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4 1.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </span>

                    <span class="text-sm sm:text-[0.95rem] md:text-base text-white/85 leading-relaxed">
                      {{ line }}
                    </span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </div>
  </div>
</template>
