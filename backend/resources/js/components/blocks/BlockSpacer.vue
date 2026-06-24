<script setup>
import { computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'

const props = defineProps({
  data: { type: Object, default: () => ({}) },
})

const heightClass = computed(() => {
  return {
    sm: 'h-6',
    md: 'h-12',
    lg: 'h-20',
  }[props.data.size || 'md']
})
</script>

<template>
  <AppContainer>
    <div :class="heightClass" class="flex items-center">
      <hr v-if="data.divider" class="w-full border-border" />
    </div>
  </AppContainer>
</template>
