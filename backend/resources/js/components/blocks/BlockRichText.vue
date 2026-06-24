<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="mt-8">
    <div
      class="prose prose-slate max-w-3xl text-text"
      v-html="data.sadrzaj || ''"
    />
  </AppContainer>
</template>
