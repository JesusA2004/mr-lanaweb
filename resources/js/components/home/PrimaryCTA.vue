<script setup lang="ts">
    defineProps<{ href?: string; label?: string }>()
    </script>
    
    <template>
      <a
        :href="href ?? '#solicitar'"
        class="inline-flex items-center justify-center rounded-2xl bg-[#1DC1A2] px-8 py-4 text-base font-semibold text-white hover:bg-[#106A59] transition"
      >
        {{ label ?? 'Solicitar ahora' }}
      </a>
    </template>
    