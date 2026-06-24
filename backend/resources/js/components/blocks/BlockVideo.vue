<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import VideoPlayer from '@/components/common/VideoPlayer.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="mt-12 space-y-6">
    <SectionHeader v-if="data.naslov" :title="data.naslov" />
    <VideoPlayer :src="data.src || ''" :poster="data.poster || ''" />
  </AppContainer>
</template>
