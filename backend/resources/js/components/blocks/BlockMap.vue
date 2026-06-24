<script setup>
import { Link } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import MapInteractive from '@/components/map/MapInteractive.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="mt-12 space-y-6">
    <SectionHeader
      :title="data.naslov || 'Mapa ponude'"
      :link-text="data.linkText || 'Otvori mapu'"
      :to="data.to || '/mapa'"
    />
    <MapInteractive :items="data.items || []" :height="data.height || '480px'" />
  </AppContainer>
</template>
