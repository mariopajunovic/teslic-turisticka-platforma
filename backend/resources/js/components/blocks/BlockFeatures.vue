<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="space-y-8">
    <div v-if="data.naslov || data.podnaslov" class="mx-auto max-w-2xl space-y-3 text-center">
      <h2 v-if="data.naslov" class="font-heading text-3xl font-bold text-heading md:text-[34px]">
        {{ data.naslov }}
      </h2>
      <p v-if="data.podnaslov" class="text-base leading-relaxed text-text-muted">
        {{ data.podnaslov }}
      </p>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 md:grid-cols-3">
      <div
        v-for="(item, i) in data.items || []"
        :key="i"
        class="flex flex-col gap-3 rounded-lg border border-border bg-surface p-6"
      >
        <div class="flex size-12 items-center justify-center rounded-lg bg-primary-tint">
          <BaseIcon :name="item.icon || 'circle'" :size="22" class="text-primary" />
        </div>
        <h3 class="font-heading text-lg font-semibold text-heading">{{ item.title }}</h3>
        <p class="text-sm leading-relaxed text-text-muted">{{ item.text }}</p>
      </div>
    </div>
  </AppContainer>
</template>
