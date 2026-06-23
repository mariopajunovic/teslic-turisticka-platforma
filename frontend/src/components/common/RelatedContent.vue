<script setup>
import CardGrid from '@/components/layout/CardGrid.vue'

defineProps({
  title: { type: String, default: 'Povezano' },
  cols: { type: Number, default: 3 },
})
</script>

<template>
  <section class="mt-12">
    <h2 class="mb-6 font-heading text-2xl font-bold text-heading">{{ title }}</h2>
    <CardGrid :cols="cols">
      <slot />
    </CardGrid>
  </section>
</template>
