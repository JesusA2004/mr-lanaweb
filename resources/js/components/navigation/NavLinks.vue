<script setup lang="ts">
    const links = [
      { label: 'Servicios', href: '/' },
      { label: 'Sucursales', href: '/sucursales' },
    ]
    </script>

    <template>
      <nav class="flex gap-6">
        <a
          v-for="link in links"
          :key="link.href"
          :href="link.href"
          class="text-sm font-medium text-slate-700 hover:text-[#1DC1A2]"
        >
          {{ link.label }}
        </a>
      </nav>
    </template>
