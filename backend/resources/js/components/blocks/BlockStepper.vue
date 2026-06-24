<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import Stepper from '@/components/common/Stepper.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="space-y-6">
    <SectionHeader v-if="data.naslov" :title="data.naslov" />
    <Stepper :steps="data.steps || []" />
  </AppContainer>
</template>
