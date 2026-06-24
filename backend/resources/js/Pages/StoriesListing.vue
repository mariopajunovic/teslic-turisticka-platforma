<script setup>
import { ref, computed, watch } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import FilterBar from '@/components/common/FilterBar.vue'
import SearchInput from '@/components/common/SearchInput.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import Pagination from '@/components/common/Pagination.vue'
import Skeleton from '@/components/common/Skeleton.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import StoryCard from '@/components/cards/StoryCard.vue'
import StoryFeaturedCard from '@/components/cards/StoryFeaturedCard.vue'

const props = defineProps({
  price: { type: Array, default: () => [] },
})

const data = computed(() => props.price)
const loading = false
const error = null

const PO_STRANICI = 9
const upit = ref('')
const kategorija = ref('')
const autor = ref('')
const stranica = ref(1)

const kategorijeOpcije = [
  { value: 'Domaćini pričaju', label: 'Domaćini pričaju' },
  { value: 'Ljudi i biznisi', label: 'Ljudi i biznisi' },
  { value: 'Naša svakodnevica', label: 'Naša svakodnevica' },
]

const autoriOpcije = computed(() => {
  const set = new Set()
  for (const p of data.value || []) if (p.autor) set.add(p.autor)
  return [...set].map((a) => ({ value: a, label: a }))
})

const istaknuta = computed(() => (data.value || []).find((p) => p.featured) || null)
const obicne = computed(() => (data.value || []).filter((p) => !p.featured))

const filtrirano = computed(() => {
  let lista = obicne.value
  if (kategorija.value) lista = lista.filter((p) => p.kategorija?.label === kategorija.value)
  if (autor.value) lista = lista.filter((p) => p.autor === autor.value)
  if (upit.value.trim()) {
    const q = upit.value.trim().toLowerCase()
    lista = lista.filter(
      (p) => p.naslov?.toLowerCase().includes(q) || p.izvod?.toLowerCase().includes(q),
    )
  }
  return lista
})

const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI)))
const vidljivi = computed(() =>
  filtrirano.value.slice((stranica.value - 1) * PO_STRANICI, stranica.value * PO_STRANICI),
)

const imaFiltera = computed(() => kategorija.value || autor.value || upit.value.trim())

const aktivniChipovi = computed(() => {
  const chips = []
  if (kategorija.value) chips.push({ key: 'kategorija', label: kategorija.value })
  if (autor.value) chips.push({ key: 'autor', label: autor.value })
  if (upit.value.trim()) chips.push({ key: 'upit', label: `„${upit.value.trim()}”` })
  return chips
})

watch([kategorija, autor, upit], () => {
  stranica.value = 1
})

function ocisti() {
  kategorija.value = ''
  autor.value = ''
  upit.value = ''
}

function ukloni(key) {
  if (key === 'kategorija') kategorija.value = ''
  if (key === 'autor') autor.value = ''
  if (key === 'upit') upit.value = ''
}
</script>

<template>
  <main class="pb-12 md:pb-16">
    <AppContainer class="pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Priče iz Teslića' }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <h1 class="font-heading text-3xl font-bold text-heading md:text-4xl">Priče iz Teslića</h1>
      <p class="mt-2 max-w-2xl text-text-muted">
        Domaćini, zanatlije i autori pričaju o ljudima, biznisima i svakodnevici kraja.
      </p>
    </AppContainer>

    <!-- Istaknuta priča -->
    <AppContainer v-if="istaknuta && !imaFiltera" class="mt-8">
      <StoryFeaturedCard :item="istaknuta" />
    </AppContainer>

    <AppContainer class="mt-8">
      <FilterBar :chips="aktivniChipovi" @clear="ocisti" @remove="ukloni">
        <FormSelect
          v-model="kategorija"
          :options="kategorijeOpcije"
          placeholder="Sve kategorije"
        />
        <FormSelect v-model="autor" :options="autoriOpcije" placeholder="Svi autori" />
        <SearchInput v-model="upit" placeholder="Pretraži priče…" />
      </FilterBar>
    </AppContainer>

    <AppContainer class="mt-8">
      <BaseAlert
        v-if="error"
        variant="greska"
        title="Greška pri učitavanju"
        text="Trenutno nije moguće učitati priče. Pokušajte ponovo kasnije."
      />

      <CardGrid v-else-if="loading" :cols="3">
        <Skeleton :count="6" />
      </CardGrid>

      <EmptyState
        v-else-if="!vidljivi.length"
        title="Nema priča"
        text="Za odabrane filtere nema priča. Pokušajte promijeniti kategoriju, autora ili pretragu."
      >
        <BaseButton variant="secondary" size="sm" @click="ocisti">Očisti filtere</BaseButton>
      </EmptyState>

      <template v-else>
        <CardGrid :cols="3">
          <StoryCard v-for="p in vidljivi" :key="p.slug" :item="p" />
        </CardGrid>
        <div v-if="ukupnoStranica > 1" class="mt-10 flex justify-center">
          <Pagination v-model="stranica" :total="ukupnoStranica" />
        </div>
      </template>
    </AppContainer>
  </main>
</template>
