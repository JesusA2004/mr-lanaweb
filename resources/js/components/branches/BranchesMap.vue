<!-- resources/js/components/branches/BranchesMap.vue -->
<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, nextTick } from 'vue'
import type { Branch } from '@/data/sucursales'
import mexicoSvgRaw from '@/assets/maps/mexico.svg?raw'

type Props = { branches: Branch[] }
const props = defineProps<Props>()

type ViewMode = 'map' | 'cards'
const viewMode = ref<ViewMode>('map')

const wrapRef = ref<HTMLElement | null>(null)
const svgHostRef = ref<HTMLElement | null>(null)

const isMobile = ref(false)
const activeStateCode = ref<string | null>(null)
const pinned = ref(false)

// Panel (viewport coords porque se teleporta al body)
const panel = ref({ show: false, x: 16, y: 16 })

let hideTimer: number | null = null
let rafPending = false
let lastMouseEvent: MouseEvent | null = null

function normalizeKey(s: string) {
  return (s || '')
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .trim()
}

const STATE_NAME_TO_CODE: Record<string, string> = {
  'aguascalientes': 'MXAGU',
  'baja california': 'MXBCN',
  'baja california sur': 'MXBCS',
  'campeche': 'MXCAM',
  'chiapas': 'MXCHP',
  'chihuahua': 'MXCHH',
  'coahuila': 'MXCOA',
  'colima': 'MXCOL',
  'ciudad de mexico': 'MXCMX',
  'cdmx': 'MXCMX',
  'durango': 'MXDUR',
  'guanajuato': 'MXGUA',
  'guerrero': 'MXGRO',
  'hidalgo': 'MXHID',
  'jalisco': 'MXJAL',
  'estado de mexico': 'MXMEX',
  'mexico': 'MXMEX',
  'michoacan': 'MXMIC',
  'morelos': 'MXMOR',
  'nayarit': 'MXNAY',
  'nuevo leon': 'MXNLE',
  'oaxaca': 'MXOAX',
  'puebla': 'MXPUE',
  'queretaro': 'MXQRO',
  'quintana roo': 'MXROO',
  'san luis potosi': 'MXSLP',
  'sinaloa': 'MXSIN',
  'sonora': 'MXSON',
  'tabasco': 'MXTAB',
  'tamaulipas': 'MXTAM',
  'tlaxcala': 'MXTLA',
  'veracruz': 'MXVER',
  'yucatan': 'MXYUC',
  'zacatecas': 'MXZAC',
}

const CODE_TO_STATE_LABEL: Record<string, string> = {
  MXAGU: 'Aguascalientes',
  MXBCN: 'Baja California',
  MXBCS: 'Baja California Sur',
  MXCAM: 'Campeche',
  MXCHP: 'Chiapas',
  MXCHH: 'Chihuahua',
  MXCMX: 'CDMX',
  MXCOA: 'Coahuila',
  MXCOL: 'Colima',
  MXDUR: 'Durango',
  MXGRO: 'Guerrero',
  MXGUA: 'Guanajuato',
  MXHID: 'Hidalgo',
  MXJAL: 'Jalisco',
  MXMEX: 'Estado de México',
  MXMIC: 'Michoacán',
  MXMOR: 'Morelos',
  MXNAY: 'Nayarit',
  MXNLE: 'Nuevo León',
  MXOAX: 'Oaxaca',
  MXPUE: 'Puebla',
  MXQRO: 'Querétaro',
  MXROO: 'Quintana Roo',
  MXSIN: 'Sinaloa',
  MXSLP: 'San Luis Potosí',
  MXSON: 'Sonora',
  MXTAB: 'Tabasco',
  MXTAM: 'Tamaulipas',
  MXTLA: 'Tlaxcala',
  MXVER: 'Veracruz',
  MXYUC: 'Yucatán',
  MXZAC: 'Zacatecas',
}

function stateLabelFromCode(code: string | null) {
  if (!code) return '—'
  return CODE_TO_STATE_LABEL[code] ?? code
}

function codeFromStateName(state: string): string | null {
  const key = normalizeKey(state)
  return STATE_NAME_TO_CODE[key] ?? null
}

const presenceCodes = computed(() => {
  const set = new Set<string>()
  for (const b of props.branches || []) {
    const code = codeFromStateName(b.state)
    if (code) set.add(code)
  }
  return set
})

const branchesByCode = computed(() => {
  const map = new Map<string, Branch[]>()
  for (const b of props.branches || []) {
    const code = codeFromStateName(b.state)
    if (!code) continue
    if (!map.has(code)) map.set(code, [])
    map.get(code)!.push(b)
  }
  for (const [, arr] of map.entries()) arr.sort((a, b) => a.name.localeCompare(b.name, 'es'))
  return map
})

const activeBranches = computed<Branch[]>(() => {
  const code = activeStateCode.value
  if (!code) return []
  return branchesByCode.value.get(code) ?? []
})

const branchesSorted = computed(() => {
  return [...(props.branches || [])].sort((a, b) => {
    const sa = a.state.localeCompare(b.state, 'es')
    if (sa !== 0) return sa
    return a.name.localeCompare(b.name, 'es')
  })
})

function mapUrlFor(branch: Branch) {
  if (branch.mapUrl) return branch.mapUrl
  const q = encodeURIComponent(branch.address)
  return `https://www.google.com/maps/search/?api=1&query=${q}`
}

function telHref(phone: string) {
  const cleaned = (phone || '').replace(/[^\d+]/g, '')
  return cleaned ? `tel:${cleaned}` : '#'
}

function clearHideTimer() {
  if (hideTimer) {
    window.clearTimeout(hideTimer)
    hideTimer = null
  }
}

function scheduleHide() {
  if (pinned.value) return
  clearHideTimer()
  hideTimer = window.setTimeout(() => {
    panel.value.show = false
    activeStateCode.value = null
  }, 160)
}

function panelSize() {
  const w = window.innerWidth < 1024 ? 320 : 360
  const count = Math.max(1, activeBranches.value.length)
  const estimated = 140 + count * 130
  const h = Math.min(Math.round(window.innerHeight * 0.7), Math.max(220, estimated))
  return { w, h }
}

function clampToViewport(x: number, y: number) {
  const pad = 12
  const { w, h } = panelSize()
  const maxX = window.innerWidth - w - pad
  const maxY = window.innerHeight - h - pad
  return {
    x: Math.max(pad, Math.min(x, maxX)),
    y: Math.max(pad, Math.min(y, maxY)),
  }
}

function setPanelPosFromMouseViewport(e: MouseEvent) {
  const { w } = panelSize()
  const prefersLeft = e.clientX > window.innerWidth * 0.62
  const rawX = prefersLeft ? e.clientX - w - 16 : e.clientX + 16
  const rawY = e.clientY + 12
  const pos = clampToViewport(rawX, rawY)
  panel.value.x = pos.x
  panel.value.y = pos.y
}

function setPanelPosNearPathViewport(pathEl: Element) {
  const pr = (pathEl as HTMLElement).getBoundingClientRect()
  const { w } = panelSize()

  const spaceRight = window.innerWidth - pr.right
  const openLeft = spaceRight < w + 24

  const rawX = openLeft ? pr.left - w - 14 : pr.right + 14
  const rawY = pr.top + pr.height / 2 - 80

  const pos = clampToViewport(rawX, rawY)
  panel.value.x = pos.x
  panel.value.y = pos.y
}

function onMove(e: MouseEvent) {
  lastMouseEvent = e
  if (rafPending) return
  rafPending = true
  requestAnimationFrame(() => {
    rafPending = false
    if (!lastMouseEvent || pinned.value) return
    setPanelPosFromMouseViewport(lastMouseEvent)
  })
}

function showPanel(code: string, eOrEl?: MouseEvent | Element) {
  clearHideTimer()
  activeStateCode.value = code
  panel.value.show = true

  if (isMobile.value) {
    panel.value.x = 0
    panel.value.y = 0
    return
  }

  if (eOrEl instanceof MouseEvent) setPanelPosFromMouseViewport(eOrEl)
  else if (eOrEl) setPanelPosNearPathViewport(eOrEl)
  else {
    const pos = clampToViewport(16, 16)
    panel.value.x = pos.x
    panel.value.y = pos.y
  }
}

function closePanel() {
  pinned.value = false
  panel.value.show = false
  activeStateCode.value = null
}

function togglePin(code: string, anchor?: Element, ev?: MouseEvent) {
  if (pinned.value && activeStateCode.value === code) {
    closePanel()
    return
  }
  pinned.value = true
  showPanel(code, anchor ?? ev)
}

function handleResize() {
  isMobile.value = window.matchMedia('(max-width: 768px)').matches
  if (panel.value.show && !isMobile.value) {
    const pos = clampToViewport(panel.value.x, panel.value.y)
    panel.value.x = pos.x
    panel.value.y = pos.y
  }
}

function onDocKey(ev: KeyboardEvent) {
  if (ev.key === 'Escape' && panel.value.show) closePanel()
}

function onDocClick(ev: MouseEvent) {
  if (!panel.value.show) return
  const t = ev.target as HTMLElement | null
  if (!t) return
  if (t.closest('[data-branches-panel="1"]')) return
  if (wrapRef.value?.contains(t)) return
  closePanel()
}

function nextFrame(): Promise<void> {
  return new Promise((resolve) => requestAnimationFrame(() => resolve()))
}

/**
 * ✅ FIX DEFINITIVO:
 * al venir de "Tarjetitas" a "Mapa", el SVG a veces no está listo para querySelector.
 * Entonces esperamos 2 frames (y nextTick) antes de buscar path y posicionar.
 */
async function focusStateFromBranch(b: Branch) {
  const code = codeFromStateName(b.state)
  if (!code) return

  viewMode.value = 'map'
  pinned.value = true

  // asegurar render de sección mapa
  await nextTick()
  await nextFrame()
  await nextFrame()

  activeStateCode.value = code
  panel.value.show = true
  handleResize()

  // móvil: bottom-sheet (no coords)
  if (isMobile.value) {
    panel.value.x = 0
    panel.value.y = 0
    return
  }

  const host = svgHostRef.value
  const path = host?.querySelector<SVGPathElement>(`svg path#${code}`) ?? null

  if (path) setPanelPosNearPathViewport(path)
  else {
    const pos = clampToViewport(16, 16)
    panel.value.x = pos.x
    panel.value.y = pos.y
  }
}

let cleanup: (() => void) | null = null

onMounted(() => {
  handleResize()
  window.addEventListener('resize', handleResize)
  document.addEventListener('click', onDocClick)
  document.addEventListener('keydown', onDocKey)

  const host = svgHostRef.value
  const wrap = wrapRef.value
  if (!host || !wrap) return

  host.innerHTML = mexicoSvgRaw

  const svg = host.querySelector('svg')
  if (!svg) return
  svg.removeAttribute('width')
  svg.removeAttribute('height')
  svg.setAttribute('preserveAspectRatio', 'xMidYMid meet')

  const paths = Array.from(svg.querySelectorAll<SVGPathElement>('path[id^="MX"]'))
  const presence = presenceCodes.value

  for (const p of paths) {
    p.classList.add('mx-state')
    p.classList.toggle('has-presence', presence.has(p.id))
    p.classList.toggle('no-presence', !presence.has(p.id))
    p.style.cursor = 'pointer'

    p.addEventListener('mouseenter', (ev) => {
      if (isMobile.value) return
      if (pinned.value) return
      showPanel(p.id, ev as unknown as MouseEvent)
    })
    p.addEventListener('mousemove', (ev) => {
      if (isMobile.value) return
      if (pinned.value) return
      onMove(ev as unknown as MouseEvent)
    })
    p.addEventListener('mouseleave', () => {
      if (isMobile.value) return
      scheduleHide()
    })

    p.addEventListener('click', (ev) => {
      ev.stopPropagation()
      if (isMobile.value) {
        pinned.value = true
        showPanel(p.id, p)
        return
      }
      togglePin(p.id, p, ev as unknown as MouseEvent)
    })
  }

  cleanup = () => {
    window.removeEventListener('resize', handleResize)
    document.removeEventListener('click', onDocClick)
    document.removeEventListener('keydown', onDocKey)
    for (const p of paths) p.replaceWith(p.cloneNode(true) as SVGPathElement)
  }
})

onBeforeUnmount(() => cleanup?.())
</script>

<template>
  <div class="mx-auto w-full max-w-[100rem] px-2 sm:px-3 md:px-4 lg:px-6 2xl:px-8">
    <!-- Toggle vista -->
    <div class="mb-3 flex flex-wrap items-center gap-2">
      <div
        class="inline-flex rounded-2xl border border-slate-200 bg-white p-1 shadow-sm
               dark:border-slate-800 dark:bg-slate-900"
      >
        <button
          type="button"
          class="rounded-xl px-3 py-2 text-xs font-extrabold tracking-wide transition"
          :class="viewMode === 'map'
            ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900'
            : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800'"
          @click="viewMode = 'map'"
        >
          Mapa
        </button>
        <button
          type="button"
          class="rounded-xl px-3 py-2 text-xs font-extrabold tracking-wide transition"
          :class="viewMode === 'cards'
            ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900'
            : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800'"
          @click="viewMode = 'cards'"
        >
          Tarjetitas
        </button>
      </div>
    </div>

    <!-- MAPA -->
    <div
      v-show="viewMode === 'map'"
      ref="wrapRef"
      class="relative w-full overflow-hidden rounded-2xl sm:rounded-3xl
             border border-slate-200 bg-white
             shadow-[0_18px_50px_rgba(2,6,23,0.10)]
             dark:border-slate-800 dark:bg-slate-950"
    >
      <div class="p-2 sm:p-4 md:p-6">
        <div
          ref="svgHostRef"
          class="w-full select-none [touch-action:manipulation]
                 min-h-[320px] sm:min-h-[420px] md:min-h-[520px] lg:min-h-[640px] xl:min-h-[720px] 2xl:min-h-[820px]"
          aria-label="Mapa de sucursales por estado"
          role="img"
        />
      </div>
    </div>

    <!-- TARJETAS -->
    <div v-show="viewMode === 'cards'" class="mt-4">
      <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
        <button
          v-for="b in branchesSorted"
          :key="b.id"
          type="button"
          class="group text-left rounded-2xl border border-slate-200 bg-white p-4
                 shadow-[0_10px_30px_rgba(2,6,23,0.08)]
                 transition hover:-translate-y-0.5 hover:shadow-[0_18px_45px_rgba(2,6,23,0.12)]
                 dark:border-slate-800 dark:bg-slate-950"
          @click="focusStateFromBranch(b)"
        >
          <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
              <div class="text-[11px] font-extrabold uppercase tracking-wide text-emerald-700 dark:text-emerald-300">
                {{ b.state }}
              </div>
              <div class="mt-1 text-sm font-extrabold text-slate-900 dark:text-slate-100">
                {{ b.name }}
              </div>
              <div class="mt-1 text-xs text-slate-600 dark:text-slate-400">
                {{ b.city }}
              </div>
            </div>

            <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-600/10 text-emerald-700 dark:text-emerald-300">
              <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 6-9 13-9 13S3 16 3 10a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
              </svg>
            </span>
          </div>

          <div class="mt-3 space-y-2">
            <div class="flex items-start gap-2 text-xs text-slate-700 dark:text-slate-200">
              <span class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-emerald-600/10 text-emerald-700 dark:text-emerald-300">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.58-1.09a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92z"></path>
                </svg>
              </span>

              <div class="min-w-0">
                <div v-if="b.phones?.length" class="flex flex-wrap gap-x-2 gap-y-1">
                  <a
                    v-for="ph in b.phones"
                    :key="ph"
                    class="font-semibold text-slate-800 hover:underline dark:text-slate-100"
                    :href="telHref(ph)"
                    @click.stop
                  >
                    {{ ph }}
                  </a>
                </div>
                <div v-else class="font-semibold text-slate-500 dark:text-slate-400">—</div>
              </div>
            </div>

            <a
              class="block text-xs font-semibold text-emerald-700 underline-offset-4 hover:underline dark:text-emerald-300"
              :href="mapUrlFor(b)"
              target="_blank"
              rel="noopener noreferrer"
              @click.stop
            >
              {{ b.address }}
            </a>
          </div>

          <div class="mt-3 text-[11px] font-extrabold text-slate-500 dark:text-slate-400">
            Ver en mapa →
          </div>
        </button>
      </div>
    </div>

    <!-- PANEL TELEPORT -->
    <Teleport to="body">
      <div
        v-show="panel.show && isMobile"
        class="fixed inset-0 z-[9998] bg-black/25 backdrop-blur-[1px]"
        @click="closePanel"
      />

      <div
        v-show="panel.show"
        class="z-[9999]"
        :class="isMobile ? 'fixed inset-x-0 bottom-0 px-3 pb-3' : 'fixed'"
        :style="isMobile ? undefined : { left: panel.x + 'px', top: panel.y + 'px' }"
      >
        <div
          data-branches-panel="1"
          class="rounded-2xl border border-slate-200 bg-white/95 shadow-2xl backdrop-blur
                 dark:border-slate-800 dark:bg-slate-950/92"
          :class="isMobile ? 'w-full' : 'w-[360px]'"
          role="dialog"
          aria-live="polite"
          :aria-label="`Sucursales en ${stateLabelFromCode(activeStateCode)}`"
          @click.stop
        >
          <div class="flex items-start justify-between gap-3 p-3 sm:p-4">
            <div class="min-w-0">
              <div class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wide text-emerald-700 dark:text-emerald-300">
                {{ stateLabelFromCode(activeStateCode) }}
              </div>

              <div class="mt-1 text-sm sm:text-[15px] font-extrabold text-slate-900 dark:text-slate-100">
                {{ activeBranches.length ? `${activeBranches.length} sucursal(es)` : 'Sin sucursal' }}
              </div>

              <div v-if="isMobile" class="mt-1 text-[11px] text-slate-600 dark:text-slate-400">
                Desliza para ver todas.
              </div>
            </div>

            <button
              type="button"
              class="grid h-9 w-9 place-items-center rounded-full border border-slate-200 bg-white text-slate-700
                     shadow-sm transition hover:bg-slate-50
                     dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800"
              aria-label="Cerrar panel"
              @click="closePanel"
            >
              <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18"></path>
                <path d="M6 6l12 12"></path>
              </svg>
              <span class="sr-only">Cerrar</span>
            </button>
          </div>

          <div
            class="px-3 pb-3 sm:px-4 sm:pb-4"
            :class="isMobile ? 'max-h-[55vh] overflow-y-auto overscroll-contain' : 'max-h-[60vh] overflow-y-auto'"
          >
            <div v-if="activeBranches.length" class="space-y-3">
              <div
                v-for="(b, idx) in activeBranches"
                :key="b.id"
                class="rounded-xl border border-slate-200 bg-white/70 p-3
                       dark:border-slate-800 dark:bg-slate-900/30"
              >
                <div class="text-sm font-extrabold text-slate-900 dark:text-slate-100">
                  {{ b.name }}
                </div>

                <div class="mt-2 space-y-2">
                  <div class="flex items-start gap-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-emerald-600/10 text-emerald-700 dark:text-emerald-300">
                      <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.58-1.09a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92z"></path>
                      </svg>
                    </span>

                    <div class="min-w-0">
                      <div v-if="b.phones?.length" class="flex flex-wrap gap-x-2 gap-y-1">
                        <a
                          v-for="ph in b.phones"
                          :key="ph"
                          class="font-semibold hover:underline"
                          :href="telHref(ph)"
                          :aria-label="`Llamar a ${b.name}: ${ph}`"
                        >
                          {{ ph }}
                        </a>
                      </div>
                      <div v-else class="font-semibold">—</div>
                    </div>
                  </div>

                  <div class="flex items-start gap-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200">
                    <span class="mt-0.5 grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-emerald-600/10 text-emerald-700 dark:text-emerald-300">
                      <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 6-9 13-9 13S3 16 3 10a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                    </span>

                    <a
                      class="font-semibold text-emerald-700 underline-offset-4 hover:underline dark:text-emerald-300"
                      :href="mapUrlFor(b)"
                      target="_blank"
                      rel="noopener noreferrer"
                      :aria-label="`Abrir ubicación en Google Maps: ${b.name}`"
                    >
                      {{ b.address }}
                    </a>
                  </div>
                </div>

                <div v-if="idx !== activeBranches.length - 1" class="mt-3 h-px bg-slate-200/70 dark:bg-slate-800/70"></div>
              </div>
            </div>

            <div v-else class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
              Sin datos disponibles para este estado.
            </div>
          </div>

          <div v-if="isMobile" class="px-3 pb-3 sm:px-4 sm:pb-4">
            <button
              type="button"
              class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-800
                     shadow-sm transition hover:bg-slate-50
                     dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800"
              @click="closePanel"
            >
              Cerrar
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>

<style scoped>
:deep(svg) {
  width: 100%;
  height: 100%;
  display: block;
}

:deep(.mx-state) {
  stroke: #ffffff;
  stroke-width: 2;
  transition: fill 0.18s ease, opacity 0.18s ease, filter 0.18s ease, transform 0.18s ease;
  transform-origin: center;
}

:deep(.mx-state.has-presence) {
  fill: #198754;
  opacity: 1;
}

:deep(.mx-state.no-presence) {
  fill: #198754;
  opacity: 0.16;
}

@media (hover: hover) and (pointer: fine) {
  :deep(.mx-state:hover) {
    opacity: 1;
    fill: #14532d;
    transform: translateY(-1px);
    filter: drop-shadow(0 10px 14px rgba(2, 6, 23, 0.12));
  }
}

@media (hover: none) and (pointer: coarse) {
  :deep(.mx-state:active) {
    filter: drop-shadow(0 10px 14px rgba(2, 6, 23, 0.14));
  }
}
</style>
