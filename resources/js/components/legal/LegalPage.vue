<script setup lang="ts">
    import TableOfContents, { type TocItem } from './TableOfContents.vue'
    
    defineProps<{
      title: string
      updatedAt?: string
      toc?: TocItem[]
    }>()
    </script>
    
    <template>
      <section class="py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="grid gap-10 lg:grid-cols-[1fr_320px] lg:items-start">
            <article class="rounded-3xl border border-slate-200 bg-white p-8 md:p-10">
              <header class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ title }}</h1>
                <p v-if="updatedAt" class="mt-2 text-sm text-slate-600">Última actualización: {{ updatedAt }}</p>
              </header>
    
              <div class="prose prose-slate max-w-none">
                <slot />
              </div>
            </article>
    
            <TableOfContents v-if="toc?.length" :items="toc" />
          </div>
        </div>
      </section>
    </template>
    
    <style scoped>
    .prose :where(h2) {
      margin-top: 2rem;
      font-weight: 800;
      color: rgb(15 23 42);
    }
    .prose :where(p, li) {
      color: rgb(51 65 85);
      line-height: 1.75;
    }
    </style>
    