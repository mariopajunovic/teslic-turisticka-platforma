<script setup>
import { ref, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import Hero from '@/components/common/Hero.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import SegmentControl from '@/components/common/SegmentControl.vue'
import FilterBar from '@/components/common/FilterBar.vue'
import SearchInput from '@/components/common/SearchInput.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import Pagination from '@/components/common/Pagination.vue'
import Skeleton from '@/components/common/Skeleton.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import CTASection from '@/components/common/CTASection.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import EventCard from '@/components/cards/EventCard.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import StoryCard from '@/components/cards/StoryCard.vue'
import EventCalendar from '@/components/calendar/EventCalendar.vue'

const props = defineProps({
  q: { type: String, default: '' },
  period: { type: String, default: '' },
  dogadjaji: { type: Object, default: () => ({ data: [], meta: { current_page: 1, last_page: 1 } }) },
  povezani: { type: Object, default: () => ({ lokalitet: null, biznis: null, prica: null }) },
})

const error = null

const prikaz = ref('lista')
const upit = ref(props.q || '')
const period = ref(props.period || '')
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

let debounceTimer = null

function reload(params) {
  router.get(
    window.location.pathname,
    params,
    { preserveState: true, preserveScroll: true, replace: true },
  )
}

watch(period, (val) => {
  reload({ period: val || undefined, q: upit.value || undefined, page: 1 })
})

watch(upit, (val) => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    reload({ period: period.value || undefined, q: val || undefined, page: 1 })
  }, 350)
})

function goPage(page) {
  reload({ period: period.value || undefined, q: upit.value || undefined, page })
}

const kalendarEvents = computed(() =>
  (props.dogadjaji.data || []).map((d) => ({ ...d, date: d.datum })),
)

const aktivniChipovi = () => {
  const chips = []
  if (period.value) {
    const p = periodOpcije.find((o) => o.value === period.value)
    chips.push({ key: 'period', label: p ? p.label : period.value })
  }
  if (upit.value.trim()) chips.push({ key: 'upit', label: `„${upit.value.trim()}"` })
  return chips
}

function ocisti() {
  period.value = ''
  upit.value = ''
  reload({})
}

function ukloni(key) {
  if (key === 'period') period.value = ''
  if (key === 'upit') upit.value = ''
  reload({ period: period.value || undefined, q: upit.value || undefined, page: 1 })
}

function onSelectDay({ events }) {
  danDogadjaji.value = events
}
</script>

<template>
  <main class="pb-12 md:pb-16">
    <Hero
      kicker="Događaji"
      kicker-class="text-secondary"
      title="Šta se dešava u Tesliću"
      subtitle="Festivali, sajmovi, izleti i kulturna dešavanja — pratite kalendar događaja teslićkog kraja."
      image="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1600&q=80"
    />

    <AppContainer class="pt-6">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Događaji' }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <SegmentControl v-model="prikaz" :options="prikazOpcije" />
      </div>
    </AppContainer>

    <AppContainer class="mt-4">
      <FilterBar :chips="aktivniChipovi()" @clear="ocisti" @remove="ukloni">
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
        <CardGrid v-if="!dogadjaji.data">
          <Skeleton :count="8" />
        </CardGrid>

        <EmptyState
          v-else-if="!dogadjaji.data.length"
          title="Nema događaja"
          text="Za odabrane filtere trenutno nema događaja. Pokušajte promijeniti period ili pretragu."
        >
          <BaseButton variant="secondary" size="sm" @click="ocisti">Očisti filtere</BaseButton>
        </EmptyState>

        <template v-else>
          <CardGrid>
            <EventCard v-for="d in dogadjaji.data" :key="d.slug" :item="d" />
          </CardGrid>
          <div v-if="dogadjaji.meta.last_page > 1" class="mt-10 flex justify-center">
            <Pagination
              :model-value="dogadjaji.meta.current_page"
              :total="dogadjaji.meta.last_page"
              @update:model-value="goPage"
            />
          </div>
        </template>
      </template>

      <!-- Prikaz: Kalendar -->
      <template v-else>
        <div class="grid gap-6 lg:grid-cols-[1fr_340px]">
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

    <!-- Povezani sadržaj -->
    <section
      v-if="povezani.lokalitet || povezani.biznis || povezani.prica"
      class="mt-12 bg-surface-alt py-12 md:py-14"
    >
      <AppContainer>
        <RelatedContent
          kicker="Povezano"
          title="Gdje se događaji dešavaju"
          class="!mt-0"
          back-to="/"
          back-label="← Nazad na Početnu"
        >
          <LocationCard v-if="povezani.lokalitet" :item="povezani.lokalitet" />
          <BusinessCard v-if="povezani.biznis" :item="povezani.biznis" />
          <StoryCard v-if="povezani.prica" :item="povezani.prica" />
        </RelatedContent>
      </AppContainer>
    </section>

    <AppContainer class="mt-12">
      <CTASection
        title="Organizujete događaj u Tesliću?"
        text="Prijavite svoj događaj i objavite ga u kalendaru platforme."
      >
        <BaseButton variant="sekundarna" to="/pridruzi-se">Prijavi događaj</BaseButton>
      </CTASection>
    </AppContainer>
  </main>
</template>
