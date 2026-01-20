<script setup lang="ts">
    const links = [
      {
        name: 'Facebook',
        href: 'https://www.facebook.com/people/Mr-Lana/61552688275964/',
        icon: '/img/icons/logo-fb.png',
      },
      {
        name: 'Instagram',
        href: 'https://www.instagram.com/mr.lana_mx/',
        icon: '/img/icons/logo-ig.png',
      },
    ]
    </script>

    <template>
      <div>
        <p class="text-sm font-semibold tracking-wide">Síguenos en</p>

        <div class="mt-3 flex flex-wrap gap-3">
          <a
            v-for="l in links"
            :key="l.name"
            :href="l.href"
            target="_blank"
            rel="noreferrer"
            class="group inline-flex items-center gap-2 rounded-xl bg-white/50 px-3 py-2 text-sm font-medium text-slate-900 ring-1 ring-black/5 transition hover:-translate-y-0.5 hover:bg-white/70 hover:ring-black/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-900/30"
          >
            <img
              :src="l.icon"
              :alt="l.name"
              class="h-4 w-4 opacity-80 transition group-hover:opacity-100"
              loading="lazy"
            />
            <span class="underline decoration-transparent underline-offset-4 transition group-hover:decoration-slate-700">
              {{ l.name }}
            </span>
          </a>
        </div>
      </div>
    </template>
