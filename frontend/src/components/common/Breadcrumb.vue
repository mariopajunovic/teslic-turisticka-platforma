<script setup>
import { RouterLink } from 'vue-router'

// items: [{ label, to }] — zadnji element je tekuća stranica (bez linka).
defineProps({
  items: { type: Array, default: () => [] },
})
</script>

<template>
  <nav aria-label="Putanja" class="flex flex-wrap items-center gap-2 text-sm">
    <template v-for="(it, i) in items" :key="i">
      <RouterLink
        v-if="it.to && i < items.length - 1"
        :to="it.to"
        class="font-medium text-primary hover:underline"
      >
        {{ it.label }}
      </RouterLink>
      <span v-else class="font-semibold text-heading" aria-current="page">{{ it.label }}</span>
      <span v-if="i < items.length - 1" class="text-text-muted">/</span>
    </template>
  </nav>
</template>
