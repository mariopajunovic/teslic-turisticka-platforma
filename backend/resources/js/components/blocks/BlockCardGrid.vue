<script setup>
import { computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import EventCard from '@/components/cards/EventCard.vue'
import AdCard from '@/components/cards/AdCard.vue'
import StoryCard from '@/components/cards/StoryCard.vue'

const props = defineProps({
  data: { type: Object, default: () => ({}) },
})

const cardByResource = {
  business: BusinessCard,
  location: LocationCard,
  event: EventCard,
  ad: AdCard,
  story: StoryCard,
}

const card = computed(() => cardByResource[props.data.resource] || BusinessCard)
const items = computed(() => props.data.items || [])
</script>

<template>
  <AppContainer class="mt-12 space-y-6">
    <SectionHeader
      v-if="data.naslov"
      :title="data.naslov"
      :link-text="data.linkText || ''"
      :to="data.to || null"
    />
    <CardGrid v-if="items.length" :cols="data.cols || 4">
      <component :is="card" v-for="item in items" :key="item.slug" :item="item" />
    </CardGrid>
    <EmptyState v-else title="Nema sadržaja" text="Trenutno nema stavki za prikaz." />
  </AppContainer>
</template>
