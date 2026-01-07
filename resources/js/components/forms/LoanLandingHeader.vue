<script setup lang="ts">
    defineProps<{
      badge?: string
      title: string
      subtitle?: string
    }>()
    </script>
    
    <template>
      <section class="py-14 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="max-w-3xl">
            <p v-if="badge" class="inline-flex rounded-full bg-white/70 px-4 py-1 text-sm font-semibold text-[#106A59] border border-white">
              {{ badge }}
            </p>
    
            <h1 class="mt-5 text-4xl font-bold tracking-tight text-slate-900 md:text-5xl">
              {{ title }}
            </h1>
    
            <p v-if="subtitle" class="mt-4 text-lg text-slate-700">
              {{ subtitle }}
            </p>
          </div>
        </div>
      </section>
    </template>
    