<script setup lang="ts">
    defineProps<{ href?: string }>()
    </script>

    <template>
      <a
        :href="href ?? '/'"
        class="inline-flex items-center transition-transform duration-200 hover:scale-[1.02] active:scale-[0.98]"
      >
        <img
          src="/img/logo-mr-lana.png"
          alt="Mr Lana"
          class="h-12 w-auto object-contain lg:h-16 xl:h-[72px]"
          loading="eager"
          draggable="false"
        />
      </a>
    </template>
