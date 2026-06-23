<script setup>
import { ref, computed, watch } from 'vue'
import { useFetch } from '@/composables/useFetch'
import { api } from '@/services/api'
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

const { data, loading, error } = useFetch(() => api.list('biznisi'))

const PO_STRANICI = 8
const upit = ref('')
const kategorija = ref('')
const stranica = ref(1)

const kategorijeOpcije = [
  { value: 'zanat', label: 'Zanatski proizvodi' },
  { value: 'hrana', label: 'Domaća hrana i piće' },
  { value: 'usluge', label: 'Usluge i servisi' },
]

const filtrirano = computed(() => {
  let lista = data.value || []
  if (kategorija.value) lista = lista.filter((b) => b.kategorija?.icon === kategorija.value)
  if (upit.value.trim()) {
    const q = upit.value.trim().toLowerCase()
    lista = lista.filter(
      (b) =>
        b.naslov?.toLowerCase().includes(q) ||
        b.opis?.toLowerCase().includes(q) ||
        b.lokacija?.toLowerCase().includes(q),
    )
  }
  return lista
})

const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI)))
const vidljivi = computed(() =>
  filtrirano.value.slice((stranica.value - 1) * PO_STRANICI, stranica.value * PO_STRANICI),
)

const aktivniChipovi = computed(() => {
  const chips = []
  if (kategorija.value) {
    const k = kategorijeOpcije.find((o) => o.value === kategorija.value)
    chips.push({ key: 'kategorija', label: k ? k.label : kategorija.value })
  }
  if (upit.value.trim()) chips.push({ key: 'upit', label: `„${upit.value.trim()}”` })
  return chips
})

watch([kategorija, upit], () => {
  stranica.value = 1
})

function ocisti() {
  kategorija.value = ''
  upit.value = ''
}

function ukloni(key) {
  if (key === 'kategorija') kategorija.value = ''
  if (key === 'upit') upit.value = ''
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
      <FilterBar :chips="aktivniChipovi" @clear="ocisti" @remove="ukloni">
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

      <CardGrid v-else-if="loading">
        <Skeleton :count="8" />
      </CardGrid>

      <EmptyState
        v-else-if="!vidljivi.length"
        title="Nema rezultata"
        text="Za odabrane filtere nema ponude. Pokušajte promijeniti kategoriju ili pretragu."
      >
        <BaseButton variant="secondary" size="sm" @click="ocisti">Očisti filtere</BaseButton>
      </EmptyState>

      <template v-else>
        <CardGrid>
          <BusinessCard v-for="b in vidljivi" :key="b.slug" :item="b" />
        </CardGrid>
        <div v-if="ukupnoStranica > 1" class="mt-10 flex justify-center">
          <Pagination v-model="stranica" :total="ukupnoStranica" />
        </div>
      </template>
    </AppContainer>
  </main>
</template>
