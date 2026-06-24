<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer>
    <InfoPanel :title="data.naslov || ''" :items="data.items || []" />
  </AppContainer>
</template>
