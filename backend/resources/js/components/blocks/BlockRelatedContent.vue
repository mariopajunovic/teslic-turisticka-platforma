<script setup>
import { computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import EventCard from '@/components/cards/EventCard.vue'

const props = defineProps({ data: { type: Object, default: () => ({}) } })
const p = computed(() => props.data.povezani || {})
const imaIsta = computed(() => p.value.biznis || p.value.lokalitet || p.value.dogadjaj)
</script>

<template>
  <AppContainer v-if="imaIsta" class="mt-12">
    <RelatedContent :kicker="data.kicker || $t('common.related')" :title="data.naslov || $t('common.related')">
      <BusinessCard v-if="p.biznis" :item="p.biznis" />
      <LocationCard v-if="p.lokalitet" :item="p.lokalitet" />
      <EventCard v-if="p.dogadjaj" :item="p.dogadjaj" />
    </RelatedContent>
  </AppContainer>
</template>
