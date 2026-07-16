<script setup>
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
import BusinessCard from '@/components/cards/BusinessCard.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import StoryCard from '@/components/cards/StoryCard.vue'
import EventCard from '@/components/cards/EventCard.vue'

const props = defineProps({
  kategorija: { type: String, default: '' },
  q: { type: String, default: '' },
  biznisi: { type: Object, default: () => ({ data: [], meta: { current_page: 1, last_page: 1 } }) },
  povezani: { type: Object, default: () => ({ lokalitet: null, prica: null, dogadjaj: null }) },
  kategorijaLabel: { type: String, default: '' },
  kategorijaOpis: { type: String, default: '' },
  kategorijaHero: { type: String, default: '' },
})

const { t } = useI18n()

const error = null

const HERO_DEFAULT =
  'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=1600&q=80'

const heroNaslov = computed(() => props.kategorijaLabel || t('local.heroTitle'))

const breadcrumb = computed(() => {
  const items = [{ label: t('common.home'), to: '/' }, { label: t('local.breadcrumb'), to: props.kategorijaLabel ? '/domace-je-najbolje' : undefined }]
  if (props.kategorijaLabel) items.push({ label: props.kategorijaLabel })
  return items
})

const kategorijeOpcije = computed(() => [
  { value: 'zanat', label: t('local.selZanat') },
  { value: 'hrana', label: t('local.selHrana') },
  { value: 'usluge', label: t('local.selUsluge') },
])

const podsekcije = computed(() => [
  { value: '', label: t('local.all') },
  { value: 'hrana', label: t('local.subHrana') },
  { value: 'zanat', label: t('local.subZanat') },
  { value: 'usluge', label: t('local.subUsluge') },
])

const kategorija = ref(props.kategorija || '')
const upit = ref(props.q || '')

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

function odaberi(val) {
  kategorija.value = val
}

const aktivniChipovi = () => {
  const chips = []
  if (kategorija.value) {
    const k = kategorijeOpcije.value.find((o) => o.value === kategorija.value)
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
      :kicker="$t('local.heroKicker')"
      kicker-class="text-primary-tint-2"
      :title="heroNaslov"
      :subtitle="$t('local.heroSubtitle')"
      :image="kategorijaHero || HERO_DEFAULT"
    />

    <AppContainer class="pt-6">
      <Breadcrumb :items="breadcrumb" />
    </AppContainer>

    <AppContainer v-if="kategorijaOpis" class="mt-4">
      <p class="max-w-3xl text-lg leading-relaxed text-text-muted">{{ kategorijaOpis }}</p>
    </AppContainer>

    <AppContainer class="mt-6">
      <FilterBar :chips="aktivniChipovi()" @clear="ocisti" @remove="ukloni">
        <FormSelect v-model="kategorija" :options="kategorijeOpcije" :placeholder="$t('common.allCategories')" />
        <SearchInput v-model="upit" :placeholder="$t('local.searchPlaceholder')" />
      </FilterBar>
    </AppContainer>

    <AppContainer class="mt-4">
      <div class="flex flex-wrap gap-2.5">
        <button
          v-for="s in podsekcije"
          :key="s.label"
          type="button"
          class="rounded-full border px-4 py-2 text-sm font-semibold transition-colors"
          :class="
            kategorija === s.value
              ? 'border-primary bg-primary text-white'
              : 'border-border bg-surface text-text hover:border-primary'
          "
          @click="odaberi(s.value)"
        >
          {{ s.label }}
        </button>
      </div>
    </AppContainer>

    <AppContainer class="mt-8">
      <BaseAlert
        v-if="error"
        variant="greska"
        :title="$t('local.errorTitle')"
        :text="$t('local.errorText')"
      />

      <CardGrid v-else-if="!biznisi.data">
        <Skeleton :count="8" />
      </CardGrid>

      <EmptyState
        v-else-if="!biznisi.data.length"
        :title="$t('common.noResults')"
        :text="$t('local.emptyText')"
      >
        <BaseButton variant="secondary" size="sm" @click="ocisti">{{ $t('common.clearFilters') }}</BaseButton>
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

    <section
      v-if="povezani.lokalitet || povezani.prica || povezani.dogadjaj"
      class="mt-12 bg-surface-alt py-12 md:py-14"
    >
      <AppContainer>
        <RelatedContent
          :kicker="$t('common.related')"
          :title="$t('local.relatedTitle')"
          class="!mt-0"
          back-to="/"
          :back-label="$t('local.backHome')"
        >
          <LocationCard v-if="povezani.lokalitet" :item="povezani.lokalitet" />
          <StoryCard v-if="povezani.prica" :item="povezani.prica" />
          <EventCard v-if="povezani.dogadjaj" :item="povezani.dogadjaj" />
        </RelatedContent>
      </AppContainer>
    </section>

    <AppContainer class="mt-12">
      <CTASection
        :title="$t('local.ctaTitle')"
        :text="$t('local.ctaText')"
      >
        <BaseButton variant="sekundarna" to="/pridruzi-se/biznis">{{ $t('local.ctaButton') }}</BaseButton>
      </CTASection>
    </AppContainer>
  </main>
</template>
