<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import Hero from '@/components/common/Hero.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import FilterBar from '@/components/common/FilterBar.vue'
import SearchInput from '@/components/common/SearchInput.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import Pagination from '@/components/common/Pagination.vue'
import Skeleton from '@/components/common/Skeleton.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'

const props = defineProps({
  kategorija: { type: String, default: '' },
  q: { type: String, default: '' },
  biznisi: { type: Object, default: () => ({ data: [], meta: { current_page: 1, last_page: 1 } }) },
})

const error = null

const kategorijeOpcije = [
  { value: 'zanat', label: 'Zanatski proizvodi' },
  { value: 'hrana', label: 'Domaća hrana i piće' },
  { value: 'usluge', label: 'Usluge i servisi' },
]

const kategorija = ref(props.kategorija || '')
const upit = ref(props.q || '')
const stranica = ref(props.biznisi.meta?.current_page ?? 1)

let debounceTimer = null

const BASE = '/domace-je-najbolje'

function reload({ kategorija: kat, q, page } = {}) {
  const path = kat ? `${BASE}/kategorija/${kat}` : BASE
  const query = {}
  if (q) query.q = q
  if (page && page > 1) query.page = page
  router.get(path, query, { preserveState: true, preserveScroll: true, replace: true })
}

watch(kategorija, (val) => {
  reload({ kategorija: val || undefined, q: upit.value || undefined, page: 1 })
})

watch(upit, (val) => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    reload({ kategorija: kategorija.value || undefined, q: val || undefined, page: 1 })
  }, 350)
})

function goPage(page) {
  reload({ kategorija: kategorija.value || undefined, q: upit.value || undefined, page })
}

const aktivniChipovi = () => {
  const chips = []
  if (kategorija.value) {
    const k = kategorijeOpcije.find((o) => o.value === kategorija.value)
    chips.push({ key: 'kategorija', label: k ? k.label : kategorija.value })
  }
  if (upit.value.trim()) chips.push({ key: 'upit', label: `„${upit.value.trim()}"` })
  return chips
}

function ocisti() {
  kategorija.value = ''
  upit.value = ''
  reload({})
}

function ukloni(key) {
  if (key === 'kategorija') kategorija.value = ''
  if (key === 'upit') upit.value = ''
  reload({ kategorija: kategorija.value || undefined, q: upit.value || undefined, page: 1 })
}
</script>

<template>
  <main class="pb-12 md:pb-16">
    <Hero
      variant="split"
      kicker="Domaće je najbolje"
      title="Lokalni proizvodi i usluge"
      subtitle="Otkrijte zanate, domaću hranu i piće te pouzdane usluge iz Teslića i okoline."
    />

    <AppContainer class="pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Domaće je najbolje' }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <FilterBar :chips="aktivniChipovi()" @clear="ocisti" @remove="ukloni">
        <FormSelect v-model="kategorija" :options="kategorijeOpcije" placeholder="Sve kategorije" />
        <SearchInput v-model="upit" placeholder="Pretraži ponudu…" />
      </FilterBar>
    </AppContainer>

    <AppContainer class="mt-8">
      <BaseAlert
        v-if="error"
        variant="greska"
        title="Greška pri učitavanju"
        text="Trenutno nije moguće učitati ponudu. Pokušajte ponovo kasnije."
      />

      <CardGrid v-else-if="!biznisi.data">
        <Skeleton :count="8" />
      </CardGrid>

      <EmptyState
        v-else-if="!biznisi.data.length"
        title="Nema rezultata"
        text="Za odabrane filtere nema ponude. Pokušajte promijeniti kategoriju ili pretragu."
      >
        <BaseButton variant="secondary" size="sm" @click="ocisti">Očisti filtere</BaseButton>
      </EmptyState>

      <template v-else>
        <CardGrid>
          <BusinessCard v-for="b in biznisi.data" :key="b.slug" :item="b" />
        </CardGrid>
        <div v-if="biznisi.meta.last_page > 1" class="mt-10 flex justify-center">
          <Pagination
            :model-value="biznisi.meta.current_page"
            :total="biznisi.meta.last_page"
            @update:model-value="goPage"
          />
        </div>
      </template>
    </AppContainer>
  </main>
</template>
