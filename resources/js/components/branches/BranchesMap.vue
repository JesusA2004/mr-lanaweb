<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'
import type { Branch } from '@/data/sucursales'
import mexicoSvgRaw from '@/assets/maps/mexico.svg?raw'

type Props = { branches: Branch[] }
const props = defineProps<Props>()

const wrapRef = ref<HTMLElement | null>(null)
const svgHostRef = ref<HTMLElement | null>(null)

const isMobile = ref(false)
const activeStateCode = ref<string | null>(null)
const pinned = ref(false)

const panel = ref({ show: false, x: 16, y: 16 })

// anti-parpadeo
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
  return map
})

const activeBranch = computed<Branch | null>(() => {
  const code = activeStateCode.value
  if (!code) return null
  const list = branchesByCode.value.get(code) ?? []
  return list[0] ?? null
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

function clampPanelPosition(x: number, y: number) {
  const wrap = wrapRef.value
  if (!wrap) return { x, y }
  const pad = 12

  const w = isMobile.value ? Math.min(360, wrap.clientWidth - 2 * pad) : (window.innerWidth < 1024 ? 300 : 340)
  const h = 150

  const maxX = wrap.clientWidth - w - pad
  const maxY = wrap.clientHeight - h - pad

  return {
    x: Math.max(pad, Math.min(x, maxX)),
    y: Math.max(pad, Math.min(y, maxY)),
  }
}

function setPanelPosFromEvent(e: MouseEvent) {
  const wrap = wrapRef.value
  if (!wrap) return
  const r = wrap.getBoundingClientRect()

  const rawX = e.clientX - r.left + 14
  const rawY = e.clientY - r.top + 14

  const pos = clampPanelPosition(rawX, rawY)
  panel.value.x = pos.x
  panel.value.y = pos.y
}

function setPanelPosNearPath(pathEl: Element) {
  const wrap = wrapRef.value
  if (!wrap) return
  const wr = wrap.getBoundingClientRect()
  const pr = (pathEl as HTMLElement).getBoundingClientRect()

  // posición “inteligente” sin parpadeo: a la derecha del estado, o izquierda si no cabe
  const preferX = pr.right - wr.left + 12
  const midY = pr.top - wr.top + pr.height / 2

  const pos = clampPanelPosition(preferX, midY - 60)
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
    setPanelPosFromEvent(lastMouseEvent)
  })
}

function showPanel(code: string, eOrEl?: MouseEvent | Element) {
  clearHideTimer()
  activeStateCode.value = code
  panel.value.show = true

  if (isMobile.value) {
    // En móvil, lo fijamos arriba-izquierda del mapa (bonito y predecible) o cerca del estado:
    if (eOrEl && !(eOrEl instanceof MouseEvent)) setPanelPosNearPath(eOrEl)
    else {
      const pos = clampPanelPosition(14, 14)
      panel.value.x = pos.x
      panel.value.y = pos.y
    }
    return
  }

  if (eOrEl instanceof MouseEvent) setPanelPosFromEvent(eOrEl)
  else if (eOrEl) setPanelPosNearPath(eOrEl)
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
  // no cierres si ya está abierto; solo re-clamp
  if (panel.value.show) {
    const pos = clampPanelPosition(panel.value.x, panel.value.y)
    panel.value.x = pos.x
    panel.value.y = pos.y
  }
}

function onDocClick(ev: MouseEvent) {
  const wrap = wrapRef.value
  if (!wrap) return
  const t = ev.target as HTMLElement | null
  if (!t) return
  // click fuera del mapa/panel => cerrar si no está fijado, o si está fijado también (UX simple)
  if (panel.value.show && !wrap.contains(t)) closePanel()
}

let cleanup: (() => void) | null = null

onMounted(() => {
  handleResize()
  window.addEventListener('resize', handleResize)
  document.addEventListener('click', onDocClick)

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

    // Desktop: hover suave, sin parpadeo
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

    // Click: móvil abre/fija panel arriba; desktop fija
    p.addEventListener('click', (ev) => {
      ev.stopPropagation()
      if (isMobile.value) {
        // en móvil, click “fija” el panel cerca del estado
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
    for (const p of paths) p.replaceWith(p.cloneNode(true) as SVGPathElement)
  }
})

onBeforeUnmount(() => cleanup?.())
</script>

<template>
  <!-- full width real -->
  <div class="mx-auto w-full max-w-[100rem] px-2 sm:px-3 md:px-4 lg:px-6 2xl:px-8">
    <div
      ref="wrapRef"
      class="relative w-full overflow-hidden rounded-2xl sm:rounded-3xl
             border border-slate-200 bg-white
             shadow-[0_18px_50px_rgba(2,6,23,0.10)]
             dark:border-slate-800 dark:bg-slate-950"
    >
      <!-- SVG grande, aprovechando -->
      <div class="p-2 sm:p-4 md:p-6">
        <div
          ref="svgHostRef"
          class="w-full select-none [touch-action:manipulation]
                 min-h-[320px] sm:min-h-[420px] md:min-h-[520px] lg:min-h-[640px] xl:min-h-[720px] 2xl:min-h-[820px]"
        />
      </div>

      <!-- Panel flotante (MÓVIL + DESKTOP) -->
      <div
        v-show="panel.show"
        class="absolute z-30"
        :style="{ left: panel.x + 'px', top: panel.y + 'px' }"
      >
        <div
          class="w-[min(360px,calc(100vw-32px))] lg:w-[340px]
                 rounded-2xl border border-slate-200 bg-white/95 p-3 sm:p-4 shadow-2xl backdrop-blur
                 dark:border-slate-800 dark:bg-slate-950/92"
          role="dialog"
          aria-live="polite"
        >
          <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
              <div class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wide text-emerald-700 dark:text-emerald-300">
                {{ stateLabelFromCode(activeStateCode) }}
              </div>

              <div class="mt-1 text-sm sm:text-[15px] font-extrabold text-slate-900 dark:text-slate-100">
                {{ activeBranch?.name ?? 'Sin sucursal' }}
              </div>
            </div>

            <!-- X SIEMPRE (móvil y desktop) -->
            <button
              type="button"
              class="grid h-9 w-9 place-items-center rounded-full border border-slate-200 bg-white text-slate-700
                     shadow-sm transition hover:bg-slate-50
                     dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800"
              aria-label="Cerrar"
              @click="closePanel"
            >
              <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18"></path>
                <path d="M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <!-- SOLO lo necesario (sin divs anidados de más) -->
          <div v-if="activeBranch" class="mt-3 space-y-2">
            <div class="flex items-center gap-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200">
              <span class="grid h-9 w-9 place-items-center rounded-xl bg-emerald-600/10 text-emerald-700 dark:text-emerald-300">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.58-1.09a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92z"></path>
                </svg>
              </span>

              <a
                v-if="activeBranch.phones?.length"
                class="font-semibold hover:underline"
                :href="telHref(activeBranch.phones[0])"
              >
                {{ activeBranch.phones.join(' · ') }}
              </a>
              <span v-else class="font-semibold">—</span>
            </div>

            <div class="flex items-start gap-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200">
              <span class="mt-0.5 grid h-9 w-9 place-items-center rounded-xl bg-emerald-600/10 text-emerald-700 dark:text-emerald-300">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 10c0 6-9 13-9 13S3 16 3 10a9 9 0 0 1 18 0z"></path>
                  <circle cx="12" cy="10" r="3"></circle>
                </svg>
              </span>

              <a
                class="font-semibold text-emerald-700 underline-offset-4 hover:underline dark:text-emerald-300"
                :href="mapUrlFor(activeBranch)"
                target="_blank"
                rel="noopener noreferrer"
              >
                {{ activeBranch.address }}
              </a>
            </div>
          </div>

          <div v-else class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            Sin datos disponibles.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
:deep(svg) {
  width: 100%;
  height: 100%;
  display: block;
}

/* Estados */
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

/* Hover desktop */
@media (hover: hover) and (pointer: fine) {
  :deep(.mx-state:hover) {
    opacity: 1;
    fill: #14532d;
    transform: translateY(-1px);
    filter: drop-shadow(0 10px 14px rgba(2, 6, 23, 0.12));
  }
}

/* Tap highlight (móvil) */
@media (hover: none) and (pointer: coarse) {
  :deep(.mx-state:active) {
    filter: drop-shadow(0 10px 14px rgba(2, 6, 23, 0.14));
  }
}
</style>
