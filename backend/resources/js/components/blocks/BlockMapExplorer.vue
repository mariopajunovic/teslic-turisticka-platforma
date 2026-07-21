<script setup>
import MapExplorer from '@/components/map/MapExplorer.vue'

defineProps({ data: { type: Object, default: () => ({}) } })
</script>

<template>
  <div class="mt-8">
    <MapExplorer :tacke="data.items || []" :naslov="data.naslov || ''" />
  </div>
</template>
