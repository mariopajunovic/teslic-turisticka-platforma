<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="mt-12">
    <SectionHeader :title="data.title || ''" :link-text="data.linkText || ''" :to="data.to || null" />
  </AppContainer>
</template>
