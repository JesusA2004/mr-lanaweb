<!-- resources/js/components/faq/FaqAccordion.vue -->
<script setup lang="ts">
    /**
     * FaqAccordion (optimizado para layout full width)
     * -----------------------------------------------
     * Objetivo:
     * - Acordeón responsivo, limpio y consistente.
     * - En este layout el acordeón vive dentro de una card clara,
     *   por eso el estilo se orienta a blanco/neutral (como la referencia).
     */

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

    /**
     * Abre el primer ítem por defecto:
     * - Da señal visual de que es interactivo.
     */
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
      <!--
        Importante:
        - Quitamos el max-w-5xl para que en pantallas grandes aproveche el ancho asignado por el grid.
        - Si quieres limitarlo, hazlo en la página contenedora, no aquí.
      -->
      <div class="w-full">
        <div class="space-y-3 sm:space-y-4">
          <div
            v-for="item in normalized"
            :key="item.id"
            class="group overflow-hidden rounded-2xl border border-slate-200 bg-white
                   shadow-sm transition hover:bg-slate-50"
            :class="{ 'ring-2 ring-orange-200 bg-slate-50': openItem === item.id }"
          >
            <button
              type="button"
              @click="toggleItem(item.id)"
              class="flex w-full items-center gap-3 sm:gap-4 px-4 sm:px-5 md:px-6 py-4 sm:py-5 text-left"
              :aria-expanded="openItem === item.id"
            >
              <!-- Badge número -->
              <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                       border border-slate-200 bg-white text-slate-900 font-extrabold text-xs sm:text-sm"
              >
                {{ item.id }}
              </div>

              <!-- Texto -->
              <div class="min-w-0 flex-1">
                <h3 class="truncate text-sm sm:text-[0.95rem] md:text-base font-extrabold text-slate-900">
                  {{ item.q }}
                </h3>
                <p class="mt-1 text-xs sm:text-sm text-slate-500">
                  Toca para ver la respuesta.
                </p>
              </div>

              <!-- Chevron -->
              <div class="shrink-0">
                <div
                  class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white transition group-hover:bg-slate-50"
                >
                  <svg
                    class="h-5 w-5 text-slate-600 transition duration-200"
                    :class="{ 'rotate-180 text-orange-600': openItem === item.id }"
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
                <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 md:p-6">
                  <!-- Respuesta como string -->
                  <div
                    v-if="typeof item.answer === 'string'"
                    class="text-sm sm:text-[0.95rem] md:text-base text-slate-700 leading-relaxed"
                  >
                    {{ item.answer }}
                  </div>

                  <!-- Respuesta como array -->
                  <div v-else class="space-y-4">
                    <p
                      v-if="item.answer.length && isIntro(item.answer[0])"
                      class="text-sm sm:text-[0.95rem] md:text-base text-slate-700 leading-relaxed"
                    >
                      {{ item.answer[0] }}
                    </p>

                    <ul class="space-y-3">
                      <li
                        v-for="(line, i) in (item.answer.length && isIntro(item.answer[0]) ? item.answer.slice(1) : item.answer)"
                        :key="i"
                        class="flex items-start gap-3"
                      >
                        <span class="mt-1 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-orange-500/10">
                          <svg class="h-3.5 w-3.5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                              fill-rule="evenodd"
                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4 1.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                              clip-rule="evenodd"
                            />
                          </svg>
                        </span>

                        <span class="text-sm sm:text-[0.95rem] md:text-base text-slate-700 leading-relaxed">
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
