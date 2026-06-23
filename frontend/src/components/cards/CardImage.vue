<script setup>
// Slika kartice (16:10) s placeholderom kad nema slike. Slot za overlay (badge/datum).
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  src: { type: String, default: '' },
  alt: { type: String, default: '' },
  ratio: { type: String, default: '16 / 10' },
})
</script>

<template>
  <div class="relative overflow-hidden bg-primary-tint" :style="{ aspectRatio: ratio }">
    <img
      v-if="src"
      :src="src"
      :alt="alt"
      loading="lazy"
      class="size-full object-cover transition-transform duration-300 group-hover:scale-105"
    />
    <div v-else class="flex size-full items-center justify-center text-primary-tint-2">
      <BaseIcon name="image" :size="36" />
    </div>
    <slot />
  </div>
</template>
