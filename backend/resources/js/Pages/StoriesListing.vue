<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
import { ref, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
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

const { t } = useI18n()

const error = null

const HERO_DEFAULT =
  'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1600&q=80'

const heroNaslov = computed(() => props.kategorijaLabel || t('stories.heroTitle'))

const breadcrumb = computed(() => {
  const items = [{ label: t('common.home'), to: localePath('/') }, { label: t('stories.breadcrumb'), to: props.kategorijaLabel ? '/price' : undefined }]
  if (props.kategorijaLabel) items.push({ label: props.kategorijaLabel })
  return items
})

const kategorijeOpcije = computed(() => [
  { value: 'domacini', label: t('stories.catDomacini') },
  { value: 'ljudi', label: t('stories.catLjudi') },
  { value: 'svakodnevica', label: t('stories.catSvakodnevica') },
])

const podsekcije = computed(() => [
  { value: '', label: t('stories.all') },
  { value: 'domacini', label: t('stories.catDomacini') },
  { value: 'ljudi', label: t('stories.catLjudi') },
  { value: 'svakodnevica', label: t('stories.catSvakodnevica') },
])

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
  if (kategorija.value) chips.push({ key: 'kategorija', label: kategorijeOpcije.value.find((o) => o.value === kategorija.value)?.label || kategorija.value })
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
      :kicker="$t('stories.heroKicker')"
      kicker-class="text-accent"
      :title="heroNaslov"
      :subtitle="$t('stories.heroSubtitle')"
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
        <FormSelect v-model="kategorija" :options="kategorijeOpcije" :placeholder="$t('common.allCategories')" />
        <FormSelect v-model="autor" :options="autoriOpcije" :placeholder="$t('stories.allAuthors')" />
        <SearchInput v-model="upit" :placeholder="$t('stories.searchPlaceholder')" />
      </FilterBar>
    </AppContainer>

    <AppContainer class="mt-8">
      <BaseAlert
        v-if="error"
        variant="greska"
        :title="$t('stories.errorTitle')"
        :text="$t('stories.errorText')"
      />

      <CardGrid v-else-if="!price.data" :cols="3">
        <Skeleton :count="6" />
      </CardGrid>

      <EmptyState
        v-else-if="!vidljivi.length"
        :title="$t('stories.emptyTitle')"
        :text="$t('stories.emptyText')"
      >
        <BaseButton variant="secondary" size="sm" @click="ocisti">{{ $t('common.clearFilters') }}</BaseButton>
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
          :kicker="$t('common.related')"
          :title="$t('stories.relatedTitle')"
          class="!mt-0"
          :back-to="localePath('/')"
          :back-label="$t('stories.backHome')"
        >
          <BusinessCard v-if="povezani.biznis" :item="povezani.biznis" />
          <LocationCard v-if="povezani.lokalitet" :item="povezani.lokalitet" />
          <EventCard v-if="povezani.dogadjaj" :item="povezani.dogadjaj" />
        </RelatedContent>
      </AppContainer>
    </section>

    <AppContainer class="mt-12">
      <CTASection
        :title="$t('stories.ctaTitle')"
        :text="$t('stories.ctaText')"
      >
        <BaseButton variant="sekundarna" :to="localePath('/pridruzi-se/autor')">{{ $t('stories.ctaButton') }}</BaseButton>
      </CTASection>
    </AppContainer>
  </main>
</template>
