<script setup>
import { computed, ref, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import FilterBar from '@/components/common/FilterBar.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import SearchInput from '@/components/common/SearchInput.vue'
import Pagination from '@/components/common/Pagination.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import EventCard from '@/components/cards/EventCard.vue'
import AdCard from '@/components/cards/AdCard.vue'
import StoryCard from '@/components/cards/StoryCard.vue'
import SegmentControl from '@/components/common/SegmentControl.vue'
import EventCalendar from '@/components/calendar/EventCalendar.vue'
import { useI18n } from 'vue-i18n'

const props = defineProps({
  data: { type: Object, default: () => ({}) },
})

const page = usePage()
const { t } = useI18n()

const cardByResource = {
  business: BusinessCard,
  location: LocationCard,
  event: EventCard,
  ad: AdCard,
  story: StoryCard,
}

const card = computed(() => cardByResource[props.data.resource] || BusinessCard)
const items = computed(() => props.data.items || [])
const meta = computed(() => props.data.meta || { current_page: 1, last_page: 1, total: 0 })

const prikaziFiltere = computed(() => Boolean(props.data.filteri))
const prikaziPretragu = computed(() => Boolean(props.data.pretraga))
const imaAlatnuTraku = computed(() => prikaziFiltere.value || prikaziPretragu.value || imaPeriod.value)

const kategorijeOpcije = computed(() => props.data.kategorije || [])

const kategorija = ref(props.data.aktivnaKategorija || '')
const upit = ref(props.data.q || '')
const period = ref(props.data.aktivniPeriod || '')

watch(() => props.data.aktivnaKategorija, (v) => { kategorija.value = v || '' })
watch(() => props.data.q, (v) => { upit.value = v || '' })
watch(() => props.data.aktivniPeriod, (v) => { period.value = v || '' })

const periodOpcije = computed(() => props.data.periodi || [])
const imaPeriod = computed(() => periodOpcije.value.length > 0)

const putanja = computed(() => (page.url || '/').split('?')[0])

const idi = (patch = {}) => {
  router.get(putanja.value, {
    kategorija: kategorija.value || undefined,
    q: upit.value || undefined,
    period: period.value || undefined,
    ...patch,
  }, { preserveState: true, preserveScroll: true, replace: true })
}

watch(kategorija, () => idi({ page: undefined }))
watch(period, () => idi({ page: undefined }))

let tajmer = null
watch(upit, () => {
  clearTimeout(tajmer)
  tajmer = setTimeout(() => idi({ page: undefined }), 300)
})

const goPage = (n) => idi({ page: n > 1 ? n : undefined })

const ocisti = () => {
  kategorija.value = ''
  upit.value = ''
  period.value = ''
  idi({ kategorija: undefined, q: undefined, period: undefined, page: undefined })
}

const jeDogadjaj = computed(() => props.data.resource === 'event')
const imaKalendar = computed(() => jeDogadjaj.value && Boolean(props.data.kalendar))

const prikaz = ref('lista')
const prikazOpcije = computed(() => [
  { value: 'lista', label: t('events.viewList'), icon: 'list' },
  { value: 'kalendar', label: t('events.viewCalendar'), icon: 'calendar' },
])

const odabraniDan = ref('')
const danDogadjaji = ref([])
const kalendarIzvor = computed(() => {
  const svi = props.data.kalendarStavke
  return Array.isArray(svi) && svi.length ? svi : items.value
})
const kalendarEvents = computed(() => kalendarIzvor.value.map((d) => ({ ...d, date: d.datumIso || d.datum })))
const onSelectDay = ({ events }) => { danDogadjaji.value = events }

const chipovi = () => {
  const lista = []
  if (kategorija.value) {
    const o = kategorijeOpcije.value.find((k) => k.value === kategorija.value)
    lista.push({ key: 'kategorija', label: o ? o.label : kategorija.value })
  }
  if (period.value) {
    const o = periodOpcije.value.find((p) => p.value === period.value)
    if (o) lista.push({ key: 'period', label: o.label })
  }
  if (upit.value) lista.push({ key: 'q', label: upit.value })
  return lista
}

const ukloni = (chip) => {
  if (chip.key === 'kategorija') kategorija.value = ''
  if (chip.key === 'q') upit.value = ''
  if (chip.key === 'period') period.value = ''
}
</script>

<template>
  <AppContainer class="mt-12 space-y-6">
    <SectionHeader v-if="data.naslov" :title="data.naslov" />

    <SegmentControl v-if="imaKalendar" v-model="prikaz" :options="prikazOpcije" />

    <FilterBar v-if="imaAlatnuTraku" :chips="chipovi()" @clear="ocisti" @remove="ukloni">
      <FormSelect
        v-if="imaPeriod"
        v-model="period"
        :options="periodOpcije"
      />
      <FormSelect
        v-if="prikaziFiltere"
        v-model="kategorija"
        :options="kategorijeOpcije"
        :placeholder="$t('common.allCategories')"
      />
      <SearchInput
        v-if="prikaziPretragu"
        v-model="upit"
        :placeholder="$t('common.search')"
        @submit="idi({ page: undefined })"
      />
    </FilterBar>

    <EmptyState
      v-if="!items.length"
      :title="$t('common.noResults')"
      :text="$t('misc.blockEmptyText')"
    >
      <BaseButton v-if="imaAlatnuTraku" variant="secondary" size="sm" @click="ocisti">
        {{ $t('common.clearFilters') }}
      </BaseButton>
    </EmptyState>

    <template v-else-if="imaKalendar && prikaz === 'kalendar'">
      <div class="grid gap-6 lg:grid-cols-[1fr_340px]">
        <EventCalendar v-model="odabraniDan" :events="kalendarEvents" @select-day="onSelectDay" />
        <div class="space-y-3">
          <h2 class="font-heading text-lg font-semibold text-heading">
            {{ $t('events.dayEvents') }} {{ odabraniDan ? `(${odabraniDan})` : '' }}
          </h2>
          <p v-if="!odabraniDan" class="text-sm text-text-muted">{{ $t('events.pickDay') }}</p>
          <EmptyState
            v-else-if="!danDogadjaji.length"
            icon="calendar"
            :title="$t('events.emptyTitle')"
            :text="$t('events.emptyDay')"
          />
          <div v-else class="space-y-4">
            <component :is="card" v-for="d in danDogadjaji" :key="d.slug" :item="d" />
          </div>
        </div>
      </div>
    </template>

    <template v-else>
      <CardGrid :cols="Number(data.cols) || 4">
        <component :is="card" v-for="item in items" :key="item.slug" :item="item" />
      </CardGrid>

      <div v-if="meta.last_page > 1" class="mt-10 flex justify-center">
        <Pagination :model-value="meta.current_page" :total="meta.last_page" @update:model-value="goPage" />
      </div>
    </template>
  </AppContainer>
</template>
