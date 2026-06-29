<script setup>
import { ref, watch, computed } from 'vue'
import { router, Link } from '@inertiajs/vue3'
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
import RelatedContent from '@/components/common/RelatedContent.vue'
import CTASection from '@/components/common/CTASection.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import EventCard from '@/components/cards/EventCard.vue'
import StoryCard from '@/components/cards/StoryCard.vue'

const props = defineProps({
  kategorija: { type: String, default: '' },
  q: { type: String, default: '' },
  lokaliteti: { type: Object, default: () => ({ data: [], meta: { current_page: 1, last_page: 1 } }) },
  povezani: { type: Object, default: () => ({ biznis: null, dogadjaj: null, prica: null }) },
  kategorijaLabel: { type: String, default: '' },
  kategorijaOpis: { type: String, default: '' },
  kategorijaHero: { type: String, default: '' },
})

const error = null

const HERO_DEFAULT =
  'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1600&q=80'

const heroNaslov = computed(() => props.kategorijaLabel || 'Priroda i baština Teslića')

const breadcrumb = computed(() => {
  const items = [{ label: 'Početna', to: '/' }, { label: 'Turizam u Tesliću', to: props.kategorijaLabel ? '/turizam' : undefined }]
  if (props.kategorijaLabel) items.push({ label: props.kategorijaLabel })
  return items
})

const kategorijeOpcije = [
  { value: 'priroda', label: 'Prirodne atrakcije' },
  { value: 'kultura', label: 'Kulturne manifestacije' },
  { value: 'planine', label: 'Planine, šume i sela' },
  { value: 'smjestaj', label: 'Gdje odsjesti' },
]

const podsekcije = [
  { key: 'priroda', label: 'Priroda', icon: 'mountain', img: 'photo-1611458182018-c043f4e947ec' },
  { key: 'kultura', label: 'Kultura i baština', icon: 'landmark', img: 'photo-1652552888460-334e60915994' },
  { key: 'planine', label: 'Planine i sela', icon: 'tent-tree', img: 'photo-1725118345125-3ceaa0599620' },
  { key: 'smjestaj', label: 'Gdje odsjesti', icon: 'bed', img: 'photo-1654156109213-00399ebbd802' },
]

const img = (id) => `https://images.unsplash.com/${id}?auto=format&fit=crop&w=600&q=80`

const kategorija = ref(props.kategorija || '')
const upit = ref(props.q || '')

let debounceTimer = null

const BASE = '/turizam'

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
      kicker="Turizam u Tesliću"
      kicker-class="text-accent"
      :title="heroNaslov"
      subtitle="Planine, rijeke, banje i kulturno nasljeđe — otkrijte lokalitete koji čine Teslić destinacijom."
      :image="kategorijaHero || HERO_DEFAULT"
    />

    <AppContainer class="pt-6">
      <Breadcrumb :items="breadcrumb" />
    </AppContainer>

    <AppContainer v-if="kategorijaOpis" class="mt-4">
      <p class="max-w-3xl text-lg leading-relaxed text-text-muted">{{ kategorijaOpis }}</p>
    </AppContainer>

    <!-- Podsekcije -->
    <AppContainer class="mt-8">
      <h2 class="font-heading text-2xl font-bold text-heading">Istražite po temama</h2>
      <div class="mt-5 grid grid-cols-2 gap-4 lg:grid-cols-4">
        <Link
          v-for="s in podsekcije"
          :key="s.key"
          :href="`/turizam/kategorija/${s.key}`"
          class="group relative flex h-44 items-end overflow-hidden rounded-lg"
        >
          <img
            :src="img(s.img)"
            :alt="s.label"
            class="absolute inset-0 size-full object-cover transition-transform duration-300 group-hover:scale-105"
          />
          <span class="absolute inset-0 bg-gradient-to-t from-overlay via-overlay/20 to-transparent" />
          <div class="relative p-4 text-white">
            <BaseIcon :name="s.icon" :size="22" />
            <p class="mt-1.5 font-heading text-lg font-bold leading-tight">{{ s.label }}</p>
          </div>
        </Link>
      </div>
    </AppContainer>

    <AppContainer class="mt-10">
      <FilterBar :chips="aktivniChipovi()" @clear="ocisti" @remove="ukloni">
        <FormSelect v-model="kategorija" :options="kategorijeOpcije" placeholder="Sve teme" />
        <SearchInput v-model="upit" placeholder="Pretraži lokalitete…" />
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
        text="Za odabrane filtere nema atrakcija. Pokušajte promijeniti temu ili pretragu."
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

    <!-- Mapa band -->
    <section class="mt-12 bg-surface-alt py-12 md:py-14">
      <AppContainer>
        <div class="grid items-center gap-8 md:grid-cols-2">
          <div>
            <p class="text-sm font-bold uppercase tracking-wider text-accent-deep">Mapa ponude</p>
            <h2 class="mt-2 font-heading text-2xl font-bold text-heading md:text-3xl">
              Svi lokaliteti na jednom mjestu
            </h2>
            <p class="mt-3 max-w-md leading-relaxed text-text-muted">
              Pregledajte atrakcije, smještaj i ponudu na interaktivnoj mapi Teslića i lako se
              orijentišite.
            </p>
            <BaseButton variant="primary" icon="arrow-right" icon-position="right" to="/mapa" class="mt-5">
              Otvori interaktivnu mapu
            </BaseButton>
          </div>
          <MiniMap label="Teslić i okolina" to="/mapa" />
        </div>
      </AppContainer>
    </section>

    <!-- Povezani sadržaj -->
    <AppContainer
      v-if="povezani.biznis || povezani.dogadjaj || povezani.prica"
      class="mt-12"
    >
      <RelatedContent
        kicker="Povezano"
        title="Spojite turizam s ponudom i pričama"
        back-to="/"
        back-label="← Nazad na Početnu"
      >
        <BusinessCard v-if="povezani.biznis" :item="povezani.biznis" />
        <EventCard v-if="povezani.dogadjaj" :item="povezani.dogadjaj" />
        <StoryCard v-if="povezani.prica" :item="povezani.prica" />
      </RelatedContent>
    </AppContainer>

    <AppContainer class="mt-12">
      <CTASection
        title="Nudite smještaj ili turističku uslugu?"
        text="Predstavite svoju ponudu posjetiocima i postanite dio turističke priče Teslića."
      >
        <BaseButton variant="sekundarna" to="/pridruzi-se/biznis">Registruj biznis</BaseButton>
      </CTASection>
    </AppContainer>
  </main>
</template>
