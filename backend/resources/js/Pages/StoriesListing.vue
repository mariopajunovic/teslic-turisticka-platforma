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
import RelatedContent from '@/components/common/RelatedContent.vue'
import CTASection from '@/components/common/CTASection.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import StoryCard from '@/components/cards/StoryCard.vue'
import StoryFeaturedCard from '@/components/cards/StoryFeaturedCard.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import EventCard from '@/components/cards/EventCard.vue'

const props = defineProps({
  kategorija: { type: String, default: '' },
  q: { type: String, default: '' },
  price: { type: Object, default: () => ({ data: [], meta: { current_page: 1, last_page: 1 } }) },
  povezani: { type: Object, default: () => ({ biznis: null, lokalitet: null, dogadjaj: null }) },
  kategorijaLabel: { type: String, default: '' },
  kategorijaOpis: { type: String, default: '' },
  kategorijaHero: { type: String, default: '' },
})

const error = null

const HERO_DEFAULT =
  'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1600&q=80'

const heroNaslov = computed(() => props.kategorijaLabel || 'Ljudi, mjesta i običaji Teslića')

const breadcrumb = computed(() => {
  const items = [{ label: 'Početna', to: '/' }, { label: 'Priče iz Teslića', to: props.kategorijaLabel ? '/price' : undefined }]
  if (props.kategorijaLabel) items.push({ label: props.kategorijaLabel })
  return items
})

const kategorijeOpcije = [
  { value: 'domacini', label: 'Domaćini pričaju' },
  { value: 'ljudi', label: 'Ljudi i biznisi' },
  { value: 'svakodnevica', label: 'Naša svakodnevica' },
]

const podsekcije = [
  { value: '', label: 'Sve' },
  { value: 'domacini', label: 'Domaćini pričaju' },
  { value: 'ljudi', label: 'Ljudi i biznisi' },
  { value: 'svakodnevica', label: 'Naša svakodnevica' },
]

const kategorija = ref(props.kategorija || '')
const upit = ref(props.q || '')
const autor = ref('')

let debounceTimer = null

const BASE = '/price'

function reload({ kategorija: kat, q, page } = {}) {
  const path = kat ? `${BASE}/kategorija/${kat}` : BASE
  const query = {}
  if (q) query.q = q
  if (page && page > 1) query.page = page
  router.get(path, query, { preserveState: true, preserveScroll: true, replace: true })
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

function odaberi(val) {
  kategorija.value = val
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
    <Hero
      kicker="Priče iz Teslića"
      kicker-class="text-accent"
      :title="heroNaslov"
      subtitle="Autentične priče domaćina, zanatlija i autora koji svojim radom i životom oblikuju kraj."
      :image="kategorijaHero || HERO_DEFAULT"
    />

    <AppContainer class="pt-6">
      <Breadcrumb :items="breadcrumb" />
    </AppContainer>

    <AppContainer v-if="kategorijaOpis" class="mt-4">
      <p class="max-w-3xl text-lg leading-relaxed text-text-muted">{{ kategorijaOpis }}</p>
    </AppContainer>

    <!-- Istaknuta priča -->
    <AppContainer v-if="istaknuta && !imaFiltera" class="mt-8">
      <StoryFeaturedCard :item="istaknuta" />
    </AppContainer>

    <!-- Podsekcije -->
    <AppContainer class="mt-8">
      <div class="flex flex-wrap gap-2.5">
        <button
          v-for="s in podsekcije"
          :key="s.label"
          type="button"
          class="rounded-full border px-4 py-2 text-sm font-semibold transition-colors"
          :class="
            kategorija === s.value
              ? 'border-accent bg-accent text-white'
              : 'border-border bg-surface text-text hover:border-accent'
          "
          @click="odaberi(s.value)"
        >
          {{ s.label }}
        </button>
      </div>
    </AppContainer>

    <AppContainer class="mt-4">
      <FilterBar :chips="aktivniChipovi()" @clear="ocisti" @remove="ukloni">
        <FormSelect v-model="kategorija" :options="kategorijeOpcije" placeholder="Sve kategorije" />
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

    <!-- Povezani sadržaj -->
    <section
      v-if="povezani.biznis || povezani.lokalitet || povezani.dogadjaj"
      class="mt-12 bg-surface-alt py-12 md:py-14"
    >
      <AppContainer>
        <RelatedContent
          kicker="Povezano"
          title="Iza svake priče stoji stvarno mjesto"
          class="!mt-0"
          back-to="/"
          back-label="← Nazad na Početnu"
        >
          <BusinessCard v-if="povezani.biznis" :item="povezani.biznis" />
          <LocationCard v-if="povezani.lokalitet" :item="povezani.lokalitet" />
          <EventCard v-if="povezani.dogadjaj" :item="povezani.dogadjaj" />
        </RelatedContent>
      </AppContainer>
    </section>

    <AppContainer class="mt-12">
      <CTASection
        title="Imate priču iz Teslića?"
        text="Postanite autor i podijelite priču o ljudima, mjestima i običajima kraja."
      >
        <BaseButton variant="sekundarna" to="/pridruzi-se/autor">Postani autor</BaseButton>
      </CTASection>
    </AppContainer>
  </main>
</template>
