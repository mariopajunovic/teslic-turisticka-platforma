<script setup>
// Lokalitet je vizuelno srodan Biznis kartici → reuse uz drugu rutu.
import BusinessCard from './BusinessCard.vue'

defineProps({
  item: { type: Object, required: true },
})
</script>

<template>
  <BusinessCard :item="item" :to="`/turizam/${item.slug}`" />
</template>
