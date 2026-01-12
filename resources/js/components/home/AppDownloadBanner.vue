<!-- resources/js/components/home/AppDownloadBanner.vue -->
<script setup lang="ts">
    type Props = {
      appStoreUrl?: string
      playStoreUrl?: string
      className?: string
    }
    
    const props = withDefaults(defineProps<Props>(), {
      appStoreUrl: '#',
      playStoreUrl: '#',
      className: '',
    })
    </script>
    
    <template>
      <section :class="['w-full bg-white', props.className]">
        <div class="mx-auto w-full max-w-screen-2xl px-4 sm:px-6 lg:px-8">
          <!-- Este contenedor ES el recorte. Nada debe vivir fuera. -->
          <div
            class="
              relative isolate w-full overflow-hidden rounded-3xl shadow-sm bg-white
              h-[220px]
              sm:h-[300px]
              md:h-[360px]
              lg:h-[410px]
              xl:h-[460px]
              2xl:h-[520px]
            "
          >
            <!-- Fondo -->
            <img
              src="/img/bannerApp/bannerFull.png"
              alt="Descarga nuestra app Mr. Lana"
              class="absolute inset-0 w-full h-full object-contain select-none"
              draggable="false"
            />
    
            <!-- CTAs: dentro del recorte SIEMPRE -->
            <div
              class="
                absolute z-10
                left-3 bottom-3
                sm:left-5 sm:bottom-5
                md:left-7 md:bottom-7
                lg:left-8 lg:bottom-8
                xl:left-10 xl:bottom-10
                2xl:left-12 2xl:bottom-12
                flex flex-col gap-2 sm:gap-3
              "
            >
              <!-- App Store -->
              <a
                :href="props.appStoreUrl"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Abrir App Store"
                class="inline-flex rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/20"
              >
                <img
                  src="/img/bannerApp/btn-dw-app-store.svg"
                  alt="Download on the App Store"
                  class="
                    object-contain select-none h-auto
                    w-[clamp(150px,22vw,300px)]
                    max-w-[calc(100%-12px)]
                  "
                  draggable="false"
                />
              </a>
    
              <!-- Google Play -->
              <a
                :href="props.playStoreUrl"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Abrir Google Play"
                class="inline-flex rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/20"
              >
                <img
                  src="/img/bannerApp/btn-dw-play-store.svg"
                  alt="Get it on Google Play"
                  class="
                    object-contain select-none h-auto
                    w-[clamp(150px,22vw,300px)]
                    max-w-[calc(100%-12px)]
                  "
                  draggable="false"
                />
              </a>
            </div>
          </div>
        </div>
      </section>
    </template>
    