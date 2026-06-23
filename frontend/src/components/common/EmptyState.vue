<script setup>
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  icon: { type: String, default: 'inbox' },
  title: { type: String, default: 'Nema rezultata' },
  text: { type: String, default: '' },
})
</script>

<template>
  <div
    class="flex flex-col items-center gap-3 rounded-md border border-border bg-surface px-6 py-12 text-center"
  >
    <span class="flex size-16 items-center justify-center rounded-full bg-primary-tint text-primary">
      <BaseIcon :name="icon" :size="28" />
    </span>
    <h3 class="text-xl font-semibold text-heading">{{ title }}</h3>
    <p v-if="text" class="max-w-sm text-sm text-text-muted">{{ text }}</p>
    <div v-if="$slots.default" class="mt-1"><slot /></div>
  </div>
</template>
