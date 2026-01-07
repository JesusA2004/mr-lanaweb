<script setup lang="ts">
    type Banner = {
        id: string
        desktopSrc: string
        mobileSrc: string
        alt?: string
        href?: string
        className?: string // por si un banner necesita margen extra
    }

    defineProps<{
        banners: Banner[]
    }>()
</script>

<template>
    <section class="w-full bg-white">
        <div class="w-full">
            <div v-for="b in banners"
                :key="b.id" class="w-full"
                :class="b.className">
                <a v-if="b.href" :href="b.href" class="block w-full">
                    <picture>
                        <source :srcset="b.mobileSrc" media="(max-width: 768px)" />
                        <img :src="b.desktopSrc"
                        :alt="b.alt ?? 'Mr Lana'"
                        class="w-full object-cover"
                        loading="lazy"/>
                    </picture>
                </a>

                <div v-else class="block w-full">
                    <picture>
                        <source :srcset="b.mobileSrc" media="(max-width: 768px)" />
                        <img :src="b.desktopSrc"
                        :alt="b.alt ?? 'Mr Lana'"
                        class="w-full object-cover"
                        loading="lazy"/>
                    </picture>
                </div>
                <br>
                <br>
                <br>
            </div>
        </div>
    </section>
</template>
