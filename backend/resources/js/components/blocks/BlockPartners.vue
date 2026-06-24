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
    <div class="flex flex-wrap items-center justify-center gap-6 md:gap-10">
      <component
        :is="item.url ? 'a' : 'div'"
        v-for="(item, i) in data.items || []"
        :key="i"
        :href="item.url || null"
        :target="item.url ? '_blank' : null"
        rel="noopener"
        class="flex h-16 items-center grayscale transition hover:grayscale-0"
      >
        <img
          v-if="item.logo"
          :src="item.logo"
          :alt="item.name"
          class="max-h-12 w-auto object-contain"
        />
        <span v-else class="font-heading text-lg font-semibold text-text-muted">{{ item.name }}</span>
      </component>
    </div>
  </AppContainer>
</template>
