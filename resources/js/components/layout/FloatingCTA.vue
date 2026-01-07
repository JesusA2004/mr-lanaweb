<script setup lang="ts">
    defineProps<{ href?: string; label?: string }>()
    </script>
    
    <template>
      <div class="fixed bottom-4 left-0 right-0 z-30 md:hidden px-4">
        <a
          :href="href ?? '#solicitar'"
          class="block w-full rounded-2xl bg-[#1DC1A2] py-4 text-center text-base font-semibold text-white shadow-lg hover:bg-[#106A59] transition"
        >
          {{ label ?? 'Solicitar ahora' }}
        </a>
      </div>
    </template>
    