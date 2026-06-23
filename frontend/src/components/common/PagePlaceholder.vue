<script setup>
// Privremeni placeholder za stranice koje još nisu implementirane (F8–F10).
import AppContainer from '@/components/layout/AppContainer.vue'

defineProps({
  title: { type: String, required: true },
  phase: { type: String, default: '' },
})
</script>

<template>
  <AppContainer as="main" class="py-12 md:py-16">
    <p v-if="phase" class="text-sm font-medium uppercase tracking-wide text-primary">
      {{ phase }}
    </p>
    <h1 class="mt-2 text-3xl font-bold text-heading md:text-4xl">{{ title }}</h1>
    <p class="mt-3 max-w-prose text-text-muted">
      Stranica je u izradi prema planu (<code>specifikacija/frontend/</code>).
    </p>
    <slot />
  </AppContainer>
</template>
