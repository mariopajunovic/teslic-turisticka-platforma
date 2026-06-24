<script setup>
import { ref, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
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
  kategorija: { type: String, default: '' },
  q: { type: String, default: '' },
  price: { type: Object, default: () => ({ data: [], meta: { current_page: 1, last_page: 1 } }) },
})

const error = null

const kategorijeOpcije = [
  { value: 'domacini', label: 'Domaćini pričaju' },
  { value: 'ljudi', label: 'Ljudi i biznisi' },
  { value: 'svakodnevica', label: 'Naša svakodnevica' },
]

const kategorija = ref(props.kategorija || '')
const upit = ref(props.q || '')
const autor = ref('')

let debounceTimer = null

function reload(params) {
  router.get(
    window.location.pathname,
    params,
    { preserveState: true, preserveScroll: true, replace: true },
  )
}

watch(kategorija, (val) => {
  autor.value = ''
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

const autoriOpcije = computed(() => {
  const set = new Set()
  for (const p of props.price.data || []) if (p.autor) set.add(p.autor)
  return [...set].map((a) => ({ value: a, label: a }))
})

const istaknuta = computed(() => {
  if (kategorija.value || upit.value.trim() || autor.value) return null
  return (props.price.data || []).find((p) => p.featured) || null
})

const vidljivi = computed(() => {
  let lista = (props.price.data || []).filter((p) => !p.featured || kategorija.value || upit.value.trim() || autor.value)
  if (autor.value) lista = lista.filter((p) => p.autor === autor.value)
  return lista
})

const imaFiltera = computed(() => kategorija.value || autor.value || upit.value.trim())

const aktivniChipovi = () => {
  const chips = []
  if (kategorija.value) chips.push({ key: 'kategorija', label: kategorijeOpcije.find((o) => o.value === kategorija.value)?.label || kategorija.value })
  if (autor.value) chips.push({ key: 'autor', label: autor.value })
  if (upit.value.trim()) chips.push({ key: 'upit', label: `„${upit.value.trim()}"` })
  return chips
}

function ocisti() {
  kategorija.value = ''
  autor.value = ''
  upit.value = ''
  reload({})
}

function ukloni(key) {
  if (key === 'kategorija') kategorija.value = ''
  if (key === 'autor') autor.value = ''
  if (key === 'upit') upit.value = ''
  reload({ kategorija: kategorija.value || undefined, q: upit.value || undefined, page: 1 })
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
      <FilterBar :chips="aktivniChipovi()" @clear="ocisti" @remove="ukloni">
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

      <CardGrid v-else-if="!price.data" :cols="3">
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
        <div v-if="price.meta.last_page > 1" class="mt-10 flex justify-center">
          <Pagination
            :model-value="price.meta.current_page"
            :total="price.meta.last_page"
            @update:model-value="goPage"
          />
        </div>
      </template>
    </AppContainer>
  </main>
</template>
