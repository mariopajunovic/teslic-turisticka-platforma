<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { useLocalePath } from '@/composables/useLocalePath'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import Hero from '@/components/common/Hero.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import Seo from '@/components/common/Seo.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import EventCard from '@/components/cards/EventCard.vue'
import StoryCard from '@/components/cards/StoryCard.vue'
import AdCard from '@/components/cards/AdCard.vue'
import NewsCard from '@/components/cards/NewsCard.vue'

const props = defineProps({
  q: { type: String, default: '' },
  grupe: { type: Array, default: () => [] },
  ukupno: { type: Number, default: 0 },
  seo: { type: Object, default: () => ({}) },
})

const { localePath } = useLocalePath()
const termin = ref(props.q)

const kartice = { BusinessCard, LocationCard, EventCard, StoryCard, AdCard, NewsCard }

function submit() {
  const q = termin.value.trim()
  if (q.length >= 2) router.visit(`${localePath('/pretraga')}?q=${encodeURIComponent(q)}`)
}
</script>

<template>
  <div>
    <Seo :seo="seo" />

    <Hero
      kicker="Pretraga"
      :title="q ? `Rezultati za „${q}“` : 'Pretraga'"
      :subtitle="q && ukupno ? `${ukupno} rezultata` : ''"
    />

    <AppContainer class="pt-6">
      <Breadcrumb :items="[{ label: 'Početna', to: localePath('/') }, { label: 'Pretraga' }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <form class="relative max-w-xl" @submit.prevent="submit">
        <BaseIcon name="search" :size="18" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-text-muted" />
        <input
          v-model="termin"
          type="search"
          placeholder="Pretraži biznise, događaje, priče…"
          class="h-12 w-full rounded-sm border border-border bg-surface pl-10 pr-4 outline-none focus:border-primary"
        />
      </form>
    </AppContainer>

    <AppContainer class="mb-16 mt-8">
      <EmptyState
        v-if="!grupe.length"
        icon="search"
        :title="q ? 'Nema rezultata' : 'Unesite pojam za pretragu'"
      >
        <span v-if="q">Za „{{ q }}“ nema rezultata. Pokušajte drugačiji pojam.</span>
      </EmptyState>

      <div v-else class="space-y-12">
        <section v-for="grupa in grupe" :key="grupa.tip">
          <SectionHeader :title="grupa.label" class="mb-5" />
          <CardGrid :cols="3">
            <component
              :is="kartice[grupa.komponenta]"
              v-for="item in grupa.items"
              :key="grupa.tip + '-' + (item.slug || item.url)"
              :item="item"
            />
          </CardGrid>
        </section>
      </div>
    </AppContainer>
  </div>
</template>
