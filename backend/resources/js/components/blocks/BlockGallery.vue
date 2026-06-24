<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import Gallery from '@/components/common/Gallery.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="mt-12 space-y-6">
    <SectionHeader v-if="data.naslov" :title="data.naslov" />
    <Gallery :items="data.items || []" :variant="data.variant || 'grid'" />
  </AppContainer>
</template>
