<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="space-y-6">
    <SectionHeader v-if="data.naslov" :title="data.naslov" />
    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
      <div
        v-for="(item, i) in data.items || []"
        :key="i"
        class="rounded-md border border-border bg-surface px-4 py-6 text-center"
      >
        <p class="font-heading text-3xl font-bold text-primary md:text-4xl">{{ item.value }}</p>
        <p class="mt-2 text-sm text-text-muted">{{ item.label }}</p>
      </div>
    </div>
  </AppContainer>
</template>
