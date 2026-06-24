<script setup>
import Hero from '@/components/common/Hero.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <Hero
    :variant="data.variant || 'split'"
    :kicker="data.kicker || ''"
    :title="data.title || ''"
    :subtitle="data.subtitle || ''"
    :image="data.image || ''"
  />
</template>
