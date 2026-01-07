<script setup lang="ts">
    import { ref } from 'vue'
    import NavLinks from './NavLinks.vue'
    
    const open = ref(false)
    </script>
    
    <template>
      <button @click="open = true" class="md:hidden">☰</button>
    
      <div v-if="open" class="fixed inset-0 z-50 bg-black/50">
        <div class="absolute right-0 h-full w-72 bg-white p-6">
          <button @click="open = false" class="mb-6 text-right">✕</button>
          <NavLinks />
        </div>
      </div>
    </template>
    