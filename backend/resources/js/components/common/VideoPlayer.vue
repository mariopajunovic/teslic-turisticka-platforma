<script setup>
// Inline video player. Native controls; placeholder kad nema src.
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  src: { type: String, default: '' },
  poster: { type: String, default: '' },
})
</script>

<template>
  <div class="overflow-hidden rounded-md bg-primary-tint">
    <video
      v-if="src"
      :src="src"
      :poster="poster || undefined"
      controls
      preload="metadata"
      class="aspect-video size-full bg-black object-contain"
    />
    <div
      v-else
      class="flex aspect-video flex-col items-center justify-center gap-2 text-primary-tint-2"
    >
      <BaseIcon name="play" :size="40" />
      <span class="text-sm font-medium">Video</span>
    </div>
  </div>
</template>
