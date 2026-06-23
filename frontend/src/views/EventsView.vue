<script setup>
import { ref, computed, watch } from 'vue'
import { useFetch } from '@/composables/useFetch'
import { api } from '@/services/api'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import SegmentControl from '@/components/common/SegmentControl.vue'
import FilterBar from '@/components/common/FilterBar.vue'
import SearchInput from '@/components/common/SearchInput.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import Pagination from '@/components/common/Pagination.vue'
import Skeleton from '@/components/common/Skeleton.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import EventCard from '@/components/cards/EventCard.vue'
import EventCalendar from '@/components/calendar/EventCalendar.vue'

const { data, loading, error } = useFetch(() => api.list('dogadjaji'))

const PO_STRANICI = 8
const prikaz = ref('lista')
const upit = ref('')
const period = ref('')
const stranica = ref(1)
const odabraniDan = ref('')
const danDogadjaji = ref([])

const prikazOpcije = [
  { value: 'lista', label: 'Lista', icon: 'list' },
  { value: 'kalendar', label: 'Kalendar', icon: 'calendar' },
]
const periodOpcije = [
  { value: 'nadolazeci', label: 'Nadolazeći' },
  { value: 'protekli', label: 'Protekli' },
]

const filtrirano = computed(() => {
  let lista = data.value || []
  if (period.value === 'nadolazeci') lista = lista.filter((d) => !d.zavrseno)
  if (period.value === 'protekli') lista = lista.filter((d) => d.zavrseno)
  if (upit.value.trim()) {
    const q = upit.value.trim().toLowerCase()
    lista = lista.filter(
      (d) => d.naslov?.toLowerCase().includes(q) || d.lokacija?.toLowerCase().includes(q),
    )
  }
  return lista
})

const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI)))
const vidljivi = computed(() =>
  filtrirano.value.slice((stranica.value - 1) * PO_STRANICI, stranica.value * PO_STRANICI),
)

// Kalendar očekuje { date: 'YYYY-MM-DD' } → mapiramo iz polja `datum`.
const kalendarEvents = computed(() =>
  (data.value || []).map((d) => ({ ...d, date: d.datum })),
)

const aktivniChipovi = computed(() => {
  const chips = []
  if (period.value) {
    const p = periodOpcije.find((o) => o.value === period.value)
    chips.push({ key: 'period', label: p ? p.label : period.value })
  }
  if (upit.value.trim()) chips.push({ key: 'upit', label: `„${upit.value.trim()}”` })
  return chips
})

watch([period, upit], () => {
  stranica.value = 1
})

function ocisti() {
  period.value = ''
  upit.value = ''
}

function ukloni(key) {
  if (key === 'period') period.value = ''
  if (key === 'upit') upit.value = ''
}

function onSelectDay({ events }) {
  danDogadjaji.value = events
}
</script>

<template>
  <main class="pb-12 md:pb-16">
    <AppContainer class="pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Događaji' }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
          <h1 class="font-heading text-3xl font-bold text-heading md:text-4xl">
            Događaji i dešavanja
          </h1>
          <p class="mt-2 max-w-2xl text-text-muted">
            Festivali, sajmovi, koncerti i manifestacije u Tesliću i okolini.
          </p>
        </div>
        <SegmentControl v-model="prikaz" :options="prikazOpcije" />
      </div>
    </AppContainer>

    <AppContainer class="mt-6">
      <FilterBar :chips="aktivniChipovi" @clear="ocisti" @remove="ukloni">
        <FormSelect v-model="period" :options="periodOpcije" placeholder="Svi periodi" />
        <SearchInput v-model="upit" placeholder="Pretraži događaje…" />
      </FilterBar>
    </AppContainer>

    <AppContainer class="mt-8">
      <BaseAlert
        v-if="error"
        variant="greska"
        title="Greška pri učitavanju"
        text="Trenutno nije moguće učitati događaje. Pokušajte ponovo kasnije."
      />

      <!-- Prikaz: Lista -->
      <template v-else-if="prikaz === 'lista'">
        <CardGrid v-if="loading">
          <Skeleton :count="8" />
        </CardGrid>

        <EmptyState
          v-else-if="!vidljivi.length"
          title="Nema događaja"
          text="Za odabrane filtere trenutno nema događaja. Pokušajte promijeniti period ili pretragu."
        >
          <BaseButton variant="secondary" size="sm" @click="ocisti">Očisti filtere</BaseButton>
        </EmptyState>

        <template v-else>
          <CardGrid>
            <EventCard v-for="d in vidljivi" :key="d.slug" :item="d" />
          </CardGrid>
          <div v-if="ukupnoStranica > 1" class="mt-10 flex justify-center">
            <Pagination v-model="stranica" :total="ukupnoStranica" />
          </div>
        </template>
      </template>

      <!-- Prikaz: Kalendar -->
      <template v-else>
        <div v-if="loading" class="grid gap-6 lg:grid-cols-[1fr_340px]">
          <div class="h-[420px] animate-pulse rounded-md bg-neutral-tint" />
          <div class="h-[420px] animate-pulse rounded-md bg-neutral-tint" />
        </div>

        <div v-else class="grid gap-6 lg:grid-cols-[1fr_340px]">
          <EventCalendar
            v-model="odabraniDan"
            :events="kalendarEvents"
            @select-day="onSelectDay"
          />
          <div class="space-y-3">
            <h2 class="font-heading text-lg font-semibold text-heading">
              Događaji {{ odabraniDan ? `(${odabraniDan})` : '' }}
            </h2>
            <p v-if="!odabraniDan" class="text-sm text-text-muted">
              Odaberite dan u kalendaru da vidite događaje.
            </p>
            <EmptyState
              v-else-if="!danDogadjaji.length"
              icon="calendar"
              title="Nema događaja"
              text="Na odabrani dan nema zakazanih događaja."
            />
            <div v-else class="space-y-4">
              <EventCard v-for="d in danDogadjaji" :key="d.slug" :item="d" />
            </div>
          </div>
        </div>
      </template>
    </AppContainer>
  </main>
</template>
