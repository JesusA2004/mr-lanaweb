<!-- resources/js/components/ui/Container.vue -->
<template>
    <!--
      Container (fluid)
      -----------------
      Objetivo:
      - Mantener padding lateral consistente, pero SIN capar el ancho con max-w.
      - Aprovechar toda la pantalla en sm/md/lg/xl/2xl.
      - Evitar que el contenido se pegue a los bordes (padding bajo control).
    -->
    <div class="mx-auto w-full px-4 sm:px-6 md:px-8 lg:px-10 2xl:px-12">
      <slot />
    </div>
  </template>
