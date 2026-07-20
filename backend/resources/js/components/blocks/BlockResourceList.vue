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

const props = defineProps({
  data: { type: Object, default: () => ({}) },
})

const page = usePage()

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
const imaAlatnuTraku = computed(() => prikaziFiltere.value || prikaziPretragu.value)

const kategorijeOpcije = computed(() => props.data.kategorije || [])

const kategorija = ref(props.data.aktivnaKategorija || '')
const upit = ref(props.data.q || '')

watch(() => props.data.aktivnaKategorija, (v) => { kategorija.value = v || '' })
watch(() => props.data.q, (v) => { upit.value = v || '' })

const putanja = computed(() => (page.url || '/').split('?')[0])

const idi = (patch = {}) => {
  router.get(putanja.value, {
    kategorija: kategorija.value || undefined,
    q: upit.value || undefined,
    ...patch,
  }, { preserveState: true, preserveScroll: true, replace: true })
}

watch(kategorija, () => idi({ page: undefined }))

let tajmer = null
watch(upit, () => {
  clearTimeout(tajmer)
  tajmer = setTimeout(() => idi({ page: undefined }), 300)
})

const goPage = (n) => idi({ page: n > 1 ? n : undefined })

const ocisti = () => {
  kategorija.value = ''
  upit.value = ''
  idi({ kategorija: undefined, q: undefined, page: undefined })
}

const chipovi = () => {
  const lista = []
  if (kategorija.value) {
    const o = kategorijeOpcije.value.find((k) => k.value === kategorija.value)
    lista.push({ key: 'kategorija', label: o ? o.label : kategorija.value })
  }
  if (upit.value) lista.push({ key: 'q', label: upit.value })
  return lista
}

const ukloni = (chip) => {
  if (chip.key === 'kategorija') kategorija.value = ''
  if (chip.key === 'q') upit.value = ''
}
</script>

<template>
  <AppContainer class="mt-12 space-y-6">
    <SectionHeader v-if="data.naslov" :title="data.naslov" />

    <FilterBar v-if="imaAlatnuTraku" :chips="chipovi()" @clear="ocisti" @remove="ukloni">
      <FormSelect
        v-if="prikaziFiltere"
        v-model="kategorija"
        :options="kategorijeOpcije"
        :placeholder="$t('common.allCategories')"
      />
      <SearchInput v-if="prikaziPretragu" v-model="upit" :placeholder="$t('common.search')" />
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

    <template v-else>
      <CardGrid :cols="data.cols || 4">
        <component :is="card" v-for="item in items" :key="item.slug" :item="item" />
      </CardGrid>

      <div v-if="meta.last_page > 1" class="mt-10 flex justify-center">
        <Pagination :model-value="meta.current_page" :total="meta.last_page" @update:model-value="goPage" />
      </div>
    </template>
  </AppContainer>
</template>
