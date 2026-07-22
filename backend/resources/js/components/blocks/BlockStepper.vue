<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="space-y-10">
    <div v-if="data.naslov || data.podnaslov" class="mx-auto max-w-2xl space-y-3 text-center">
      <h2 v-if="data.naslov" class="font-heading text-3xl font-bold text-heading md:text-[34px]">
        {{ data.naslov }}
      </h2>
      <p v-if="data.podnaslov" class="text-base leading-relaxed text-text-muted">
        {{ data.podnaslov }}
      </p>
    </div>

    <div class="relative mx-auto max-w-4xl">
      <div class="absolute left-[16.667%] right-[16.667%] top-7 hidden h-0.5 bg-border md:block" />
      <div class="grid gap-8 md:grid-cols-3 md:gap-6">
        <div
          v-for="(step, i) in data.steps || []"
          :key="i"
          class="flex flex-col items-center gap-3 text-center"
        >
          <div
            class="relative z-10 flex size-14 items-center justify-center rounded-full bg-primary ring-4 ring-surface"
          >
            <BaseIcon :name="step.icon || 'circle'" :size="24" class="text-white" />
          </div>
          <p class="text-xs font-semibold uppercase tracking-wider text-primary">Korak {{ i + 1 }}</p>
          <h3 class="font-heading text-xl font-bold text-heading">{{ step.title }}</h3>
          <p class="max-w-xs text-sm leading-relaxed text-text-muted">{{ step.text }}</p>
        </div>
      </div>
    </div>
  </AppContainer>
</template>
