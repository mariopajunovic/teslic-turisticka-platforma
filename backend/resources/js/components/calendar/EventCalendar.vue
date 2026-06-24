<script setup>
import { computed, ref } from 'vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const props = defineProps({
  events: { type: Array, default: () => [] },
  initialMonth: { type: [Date, String], default: null },
})

const emit = defineEmits(['selectDay'])

// Odabrani dan kao 'YYYY-MM-DD'
const selected = defineModel({ type: String, default: '' })

const MJESECI = [
  'Januar',
  'Februar',
  'Mart',
  'April',
  'Maj',
  'Jun',
  'Jul',
  'Avgust',
  'Septembar',
  'Oktobar',
  'Novembar',
  'Decembar',
]
const DANI = ['Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub', 'Ned']

// Pomoćno: 'YYYY-MM-DD' iz lokalnih komponenti (bez vremenske zone)
const pad = (n) => String(n).padStart(2, '0')
const toIso = (y, m, d) => `${y}-${pad(m + 1)}-${pad(d)}`

// Početni mjesec → prvi dan tog mjeseca
function parseInitial(value) {
  if (value instanceof Date) return new Date(value.getFullYear(), value.getMonth(), 1)
  if (typeof value === 'string') {
    const [y, m] = value.split('-').map(Number)
    if (y && m) return new Date(y, m - 1, 1)
  }
  const now = new Date()
  return new Date(now.getFullYear(), now.getMonth(), 1)
}

const cursor = ref(parseInitial(props.initialMonth))

const godina = computed(() => cursor.value.getFullYear())
const mjesec = computed(() => cursor.value.getMonth())
const naslov = computed(() => `${MJESECI[mjesec.value]} ${godina.value}`)

function prethodni() {
  cursor.value = new Date(godina.value, mjesec.value - 1, 1)
}
function sljedeci() {
  cursor.value = new Date(godina.value, mjesec.value + 1, 1)
}

// Mapa datum → broj događaja
const brojPoDanu = computed(() => {
  const map = {}
  for (const e of props.events) {
    if (!e?.date) continue
    map[e.date] = (map[e.date] || 0) + 1
  }
  return map
})

function dogadjajiZa(date) {
  return props.events.filter((e) => e?.date === date)
}

const danasIso = computed(() => {
  const n = new Date()
  return toIso(n.getFullYear(), n.getMonth(), n.getDate())
})

// Mreža: počinje ponedjeljkom, uvijek 6 redova (42 ćelije) radi stabilnog layouta
const dani = computed(() => {
  const y = godina.value
  const m = mjesec.value
  const prviDan = new Date(y, m, 1)
  // getDay(): 0=Ned … 6=Sub → pretvaramo u offset gdje je Pon=0
  const offset = (prviDan.getDay() + 6) % 7

  const celije = []
  // Početak mreže = ponedjeljak prije/na prvi dan mjeseca
  const start = new Date(y, m, 1 - offset)

  for (let i = 0; i < 42; i++) {
    const d = new Date(start.getFullYear(), start.getMonth(), start.getDate() + i)
    const iso = toIso(d.getFullYear(), d.getMonth(), d.getDate())
    celije.push({
      iso,
      broj: d.getDate(),
      uMjesecu: d.getMonth() === m,
      brojDogadjaja: brojPoDanu.value[iso] || 0,
    })
  }
  return celije
})

function imeMjeseca(iso) {
  const m = Number(iso.split('-')[1]) - 1
  return MJESECI[m]
}

function ariaLabel(celija) {
  const m = imeMjeseca(celija.iso)
  let label = `${celija.broj}. ${m} ${celija.iso.split('-')[0]}`
  if (celija.iso === danasIso.value) label += ', danas'
  if (celija.brojDogadjaja > 0) {
    label += `, ${celija.brojDogadjaja} ${celija.brojDogadjaja === 1 ? 'događaj' : 'događaja'}`
  }
  return label
}

const odabranoTekst = computed(() => {
  if (!selected.value) return ''
  const [y, m, d] = selected.value.split('-')
  return `${Number(d)}. ${MJESECI[Number(m) - 1]} ${y}`
})

function odaberi(celija) {
  selected.value = celija.iso
  emit('selectDay', { date: celija.iso, events: dogadjajiZa(celija.iso) })
}
</script>

<template>
  <div class="rounded-md border border-border bg-surface p-4 shadow-[var(--shadow-sm)] sm:p-5">
    <!-- Zaglavlje -->
    <div class="mb-4 flex items-center justify-between">
      <button
        type="button"
        class="flex h-10 w-10 items-center justify-center rounded-sm border border-border text-text-muted transition-colors hover:bg-surface-alt"
        aria-label="Prethodni mjesec"
        @click="prethodni"
      >
        <BaseIcon name="chevron-left" :size="20" />
      </button>

      <h3 class="flex items-center gap-2 font-heading text-lg font-semibold text-heading">
        <BaseIcon name="calendar" :size="18" />
        {{ naslov }}
      </h3>

      <button
        type="button"
        class="flex h-10 w-10 items-center justify-center rounded-sm border border-border text-text-muted transition-colors hover:bg-surface-alt"
        aria-label="Sljedeći mjesec"
        @click="sljedeci"
      >
        <BaseIcon name="chevron-right" :size="20" />
      </button>
    </div>

    <!-- Skraćeni dani -->
    <div class="grid grid-cols-7 gap-1">
      <div
        v-for="dan in DANI"
        :key="dan"
        class="py-1 text-center text-[11px] font-semibold uppercase tracking-wide text-text-muted"
      >
        {{ dan }}
      </div>
    </div>

    <!-- Mreža dana -->
    <div class="mt-1 grid grid-cols-7 gap-1">
      <button
        v-for="celija in dani"
        :key="celija.iso"
        type="button"
        :aria-label="ariaLabel(celija)"
        :aria-pressed="selected === celija.iso"
        :aria-current="celija.iso === danasIso ? 'date' : undefined"
        class="relative flex aspect-square min-h-[40px] flex-col items-center justify-center rounded-sm text-sm transition-colors sm:min-h-[44px]"
        :class="[
          selected === celija.iso
            ? 'bg-primary font-semibold text-white'
            : celija.iso === danasIso
              ? 'bg-primary-tint font-semibold text-primary hover:bg-primary-tint-2'
              : celija.uMjesecu
                ? 'text-text hover:bg-surface-alt'
                : 'text-text-muted/50 hover:bg-surface-alt',
        ]"
        @click="odaberi(celija)"
      >
        <span class="leading-none">{{ celija.broj }}</span>

        <!-- Tačke za događaje -->
        <span
          v-if="celija.brojDogadjaja > 0"
          class="absolute bottom-1.5 flex items-center gap-0.5"
          aria-hidden="true"
        >
          <span
            v-for="n in Math.min(celija.brojDogadjaja, 3)"
            :key="n"
            class="h-1 w-1 rounded-pill"
            :class="selected === celija.iso ? 'bg-white' : 'bg-primary'"
          />
        </span>
      </button>
    </div>

    <!-- Suptilna oznaka odabranog dana -->
    <p v-if="selected" class="mt-4 text-sm text-text-muted">
      Odabrano: <span class="font-semibold text-text">{{ odabranoTekst }}</span>
    </p>
  </div>
</template>
