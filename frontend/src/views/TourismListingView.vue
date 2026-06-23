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
import MiniMap from '@/components/common/MiniMap.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import LocationCard from '@/components/cards/LocationCard.vue'

const { data, loading, error } = useFetch(() => api.list('lokaliteti'))

const PO_STRANICI = 8
const upit = ref('')
const kategorija = ref('')
const stranica = ref(1)

const kategorijeOpcije = [
  { value: 'priroda', label: 'Prirodne atrakcije' },
  { value: 'kultura', label: 'Kulturne manifestacije' },
  { value: 'smjestaj', label: 'Gdje odsjesti' },
]

const filtrirano = computed(() => {
  let lista = data.value || []
  if (kategorija.value) lista = lista.filter((l) => l.kategorija?.icon === kategorija.value)
  if (upit.value.trim()) {
    const q = upit.value.trim().toLowerCase()
    lista = lista.filter(
      (l) =>
        l.naslov?.toLowerCase().includes(q) ||
        l.opis?.toLowerCase().includes(q) ||
        l.lokacija?.toLowerCase().includes(q),
    )
  }
  return lista
})

const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI)))
const vidljivi = computed(() =>
  filtrirano.value.slice((stranica.value - 1) * PO_STRANICI, stranica.value * PO_STRANICI),
)
const preporuceni = computed(() => (data.value || []).filter((l) => l.preporuceno).slice(0, 3))

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
      variant="slika-pozadina"
      kicker="Turizam u Tesliću"
      title="Priroda, kultura i mjesta za odmor"
      subtitle="Planina Borja, Banja Vrućica, vrh Očauš i druge atrakcije kraja na jednom mjestu."
    />

    <AppContainer class="pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Turizam u Tesliću' }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <FilterBar :chips="aktivniChipovi" @clear="ocisti" @remove="ukloni">
        <FormSelect v-model="kategorija" :options="kategorijeOpcije" placeholder="Sve kategorije" />
        <SearchInput v-model="upit" placeholder="Pretraži atrakcije…" />
      </FilterBar>
    </AppContainer>

    <AppContainer class="mt-8">
      <BaseAlert
        v-if="error"
        variant="greska"
        title="Greška pri učitavanju"
        text="Trenutno nije moguće učitati atrakcije. Pokušajte ponovo kasnije."
      />

      <CardGrid v-else-if="loading">
        <Skeleton :count="8" />
      </CardGrid>

      <EmptyState
        v-else-if="!vidljivi.length"
        title="Nema rezultata"
        text="Za odabrane filtere nema atrakcija. Pokušajte promijeniti kategoriju ili pretragu."
      >
        <BaseButton variant="secondary" size="sm" @click="ocisti">Očisti filtere</BaseButton>
      </EmptyState>

      <template v-else>
        <CardGrid>
          <LocationCard v-for="l in vidljivi" :key="l.slug" :item="l" />
        </CardGrid>
        <div v-if="ukupnoStranica > 1" class="mt-10 flex justify-center">
          <Pagination v-model="stranica" :total="ukupnoStranica" />
        </div>
      </template>
    </AppContainer>

    <!-- Mapa isječak -->
    <AppContainer class="mt-12">
      <h2 class="mb-6 font-heading text-2xl font-bold text-heading">Ponuda na mapi</h2>
      <div class="max-w-md">
        <MiniMap label="Teslić i okolina" to="/mapa" />
      </div>
    </AppContainer>

    <!-- Preporučene lokacije -->
    <AppContainer v-if="preporuceni.length" class="mt-12">
      <h2 class="mb-6 font-heading text-2xl font-bold text-heading">Preporučene lokacije</h2>
      <CardGrid :cols="3">
        <LocationCard v-for="l in preporuceni" :key="l.slug" :item="l" />
      </CardGrid>
    </AppContainer>
  </main>
</template>
