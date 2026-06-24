<script setup>
import { ref, watch, computed } from 'vue'
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
import MiniMap from '@/components/common/MiniMap.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import LocationCard from '@/components/cards/LocationCard.vue'

const props = defineProps({
  kategorija: { type: String, default: '' },
  q: { type: String, default: '' },
  lokaliteti: { type: Object, default: () => ({ data: [], meta: { current_page: 1, last_page: 1 } }) },
})

const error = null

const kategorijeOpcije = [
  { value: 'priroda', label: 'Prirodne atrakcije' },
  { value: 'kultura', label: 'Kulturne manifestacije' },
  { value: 'planine', label: 'Planine, šume i sela' },
  { value: 'smjestaj', label: 'Gdje odsjesti' },
]

const kategorija = ref(props.kategorija || '')
const upit = ref(props.q || '')

let debounceTimer = null

function reload(params) {
  router.get(
    window.location.pathname,
    params,
    { preserveState: true, preserveScroll: true, replace: true },
  )
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

const preporuceni = computed(() => (props.lokaliteti.data || []).filter((l) => l.preporuceno).slice(0, 3))

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
      variant="slika-pozadina"
      kicker="Turizam u Tesliću"
      title="Priroda, kultura i mjesta za odmor"
      subtitle="Planina Borja, Banja Vrućica, vrh Očauš i druge atrakcije kraja na jednom mjestu."
    />

    <AppContainer class="pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Turizam u Tesliću' }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <FilterBar :chips="aktivniChipovi()" @clear="ocisti" @remove="ukloni">
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

      <CardGrid v-else-if="!lokaliteti.data">
        <Skeleton :count="8" />
      </CardGrid>

      <EmptyState
        v-else-if="!lokaliteti.data.length"
        title="Nema rezultata"
        text="Za odabrane filtere nema atrakcija. Pokušajte promijeniti kategoriju ili pretragu."
      >
        <BaseButton variant="secondary" size="sm" @click="ocisti">Očisti filtere</BaseButton>
      </EmptyState>

      <template v-else>
        <CardGrid>
          <LocationCard v-for="l in lokaliteti.data" :key="l.slug" :item="l" />
        </CardGrid>
        <div v-if="lokaliteti.meta.last_page > 1" class="mt-10 flex justify-center">
          <Pagination
            :model-value="lokaliteti.meta.current_page"
            :total="lokaliteti.meta.last_page"
            @update:model-value="goPage"
          />
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
